<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedules;
use App\Members;
use App\Week;
use App\Dates;
use App\Month;
use Excel;
use App\Exports\ScheduleExport;

class SchedulesController extends Controller
{
    public function index(Request $request, $shopId)
    {
        $current_month = $request->choose_month ? : date('n');
        $year = (date('n') == '12' && $current_month == '1') ? date('Y') + 1 : date('Y');
        $days = date('t', strtotime($year . '-' . $current_month));
        $humans = Members::actived()->get();
        $schedules = Schedules::where('shop_id', $shopId)
            ->where('year', $year)
            ->where('month', $current_month)
            ->where('actived', true)
            ->orderBy('day', 'ASC')->get();
        foreach ($schedules as $schedule) {
            if ($schedule->shift !== 'off') {
                $schedule->shift = unserialize($schedule->shift);
            }
        }
        $week = ['0', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
        $month = Month::find(1)->number;
        $anchor = $request->anchor ? : $year . '_' . $current_month . '_' . date("j");
        return view('front.schedule.index', compact('schedules', 'humans', 'week', 'month', 'current_month', 'anchor', 'shopId'));
    }

    public function admin_index(Request $request, $shopId)
    {
        $schedules = Schedules::where('actived', false)->where('shop_id', $shopId)->orderBy('day', 'ASC')->get();
        // $year = Schedules::where('actived', false)->first()->year;
        $humans = Members::actived()->get();
        foreach ($schedules as $schedule) {
            if ($schedule->shift !== 'off') {
                $schedule->shift = unserialize($schedule->shift);
            }
        }
        $week = ['0', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
        $month = Month::find(1)->number;
        $anchor = $request->anchor ? : null;
        return view('front.schedule.unactived', compact('schedules', 'humans', 'week', 'month', 'anchor', 'shopId'));
    }

    public function schedules_week(Request $request, $shopId)
    {
        $month = $request->month;
        $year = $request->year;

        $current_month = $month;
        $days = date('t', strtotime($year . '-' . $current_month));
        $humans = Members::actived()->get();
        $schedules = Schedules::where('shop_id', $shopId)->where('year', $year)->where('month', $current_month)->get();
        foreach ($schedules as $schedule) {
            if ($schedule->shift !== 'off') {
                $schedule->shift = unserialize($schedule->shift);
            } else {
                $schedule->shift = [[0, 1]];
            }
        }
        $week = ['0', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
        $first_weekday_number = date('w', mktime(0, 0, 0, $current_month, 1, $year)) - 1;
        $month = Month::find(1)->number;
        $nav_hidden = 'hidden';
        return view('front.schedule.index_week', compact('schedules', 'humans', 'week', 'month', 'days', 'current_month', 'first_weekday_number', 'nav_hidden', 'shopId'));
    }

    public function check(Request $request)
    {
        $current_month = $request->checked_month;
        $year = $request->checked_year;
        $days = date('t', strtotime($year . '-' . $current_month));
        $humans = Members::actived()->get();
        $dates = Dates::where('year', $year)->where('month', $current_month)->get();
        $week = ['0', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
        $month = Month::find(1)->number;
        return view('front.schedule.check', compact('dates', 'humans', 'week', 'month', 'year', 'current_month', 'days'));
    }

    public function weekday()
    {
        $weekdays = Week::all();
        $weekday = Week::find(7);
        return view('front.work.weekday', compact('weekdays'));
    }

    public function edit($year, $month, $day)
    {
        $shopId = 'Y'; //default
        $current_month = $month;
        $schedule_Y = Schedules::where('shop_id', 'Y')->dates($year, $current_month, $day)->first();
        if ($schedule_Y->shift !== 'off') {
            $schedule_Y->shift = unserialize($schedule_Y->shift);
        } else {
            $schedule_Y->shift = [[0, 1]];
        }
        $schedule_A = Schedules::where('shop_id', 'A')->dates($year, $current_month, $day)->first();
        if ($schedule_A->shift !== 'off') {
            $schedule_A->shift = unserialize($schedule_A->shift);
        } else {
            $schedule_A->shift = [[0, 1]];
        }
        $dates = Dates::dates($year, $current_month, $day)->get();
        $week = ['0', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
        $humans = Members::all();
        $month = Month::find(1)->number;

        //cal
        $schedules = Schedules::where('year', $year)->where('month', $current_month)->get();
        $member_total = $this->getMember($schedules);
        return view('front.schedule.edit', compact('schedule_Y', 'schedule_A', 'dates', 'week', 'humans', 'month', 'current_month', 'member_total', 'shopId'));
    }

    public function update($year, $month, $day, Request $request)
    {
        $data = $request->all();
        $humans = Members::actived()->get();
        $shift_Y = [];
        $shift_A = [];
        foreach ($humans as $human) {
            $i = $human->id;
            $name = $human->name;
            if ($data[$name . '_started_Y'] && $data[$name . '_ended_Y']) {
                array_push($shift_Y, [
                    Members::find($i)->name => [$data[$name . '_started_Y'], $data[$name . '_ended_Y']]
                ]);
            }
            if ($data[$name . '_started_A'] && $data[$name . '_ended_A']) {
                array_push($shift_A, [
                    Members::find($i)->name => [$data[$name . '_started_A'], $data[$name . '_ended_A']]
                ]);
            }
        }
        // if ($data['lack_human_started'] && $data['lack_human_ended']) {
        //     array_push($shift, [
        //         'lack_human' => [$data['lack_human_started'], $data['lack_human_ended']]
        //     ]);
        // }
        if (!empty($shift_Y)) {
            Schedules::where('shop_id', 'Y')->dates($year, $month, $day)->update([
                'shift' => serialize($shift_Y)
            ]);
        }
        if (!empty($shift_A)) {
            Schedules::where('shop_id', 'A')->dates($year, $month, $day)->update([
                'shift' => serialize($shift_A)
            ]);
        }
        // return redirect()->back();
        if (Schedules::dates($year, $month, $day)->first()->actived === 0) {
            return redirect('/Y/un_schedules?choose_month=' . $month . '&anchor=' . $year . '_' . $month . '_' . $day);
        } else {
            return redirect('/Y/schedules?choose_month=' . $month . '&anchor=' . $year . '_' . $month . '_' . $day);
        }
    }

    public function calculate_time(Request $request)
    {
        $schedule = Schedules::where('year', $request->calculate_year)->where('month', $request->calculate_month)->get();
        $member_total = $this->getMember($schedule);
        $humans = Members::actived()->get();
        $month = Month::find(1) ? Month::find(1)->number : null;
        return view('front.work.calculate', compact('humans', 'month', 'member_total'));
    }

    protected function getMember($schedules)
    {
        $members = Members::all();
        $member_total = [];
        foreach ($members as $member) {
            $array = [$member->name => 0];
            $member_total = array_merge($member_total, $array);
        }
        foreach ($schedules as $schedule) {
            if ($schedule->shift !== 'off') {
                $shift = unserialize($schedule->shift);
                if ($shift) {
                    foreach ($shift as $item) {
                        $name = array_keys($item)[0];
                        if ($name != 'lack_human') {
                            $number = $item[$name][1] - $item[$name][0];
                            $member_total[$name] = $member_total[$name] + $number;
                        }
                    }
                }
            }
        }
        return $member_total;
    }

    public function publish_schedule(Request $request)
    {
        $year = $request->publish_year;
        $month = $request->publish_month;
        $schedules = Schedules::where('year', $year)->where('month', $month)->get();
        if ($schedules) {
            foreach ($schedules as $schedule) {
                $schedule->update([
                    'actived' => true
                ]);
            }
        }
        return redirect()->action('SchedulesController@index');
    }

    public function export(Request $request)
    {
        $excel = Excel::download(new ScheduleExport($request), 'LBC_班表' . $request->year . '_' . $request->month . '.xlsx');
        return $excel;
    }
}
