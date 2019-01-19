<?php

namespace App\Http\Controllers;

use App\Dates;
use App\Schedules;
use App\Members;
use App\Option;
use Illuminate\Http\Request;

class DatesController extends Controller
{
    public function give_shift($id, $month)
    {
        // $month = ($month == '12') ? '1' : date('n')+1;
        // $month = '11';
        $current_month = $month;
        $today = date("j");
        $now= date("H");
        $limit_date = Option::find(1)->limit_date;
        $limit_hour = Option::find(1)->limit_hour;
        $not_limit = ($limit_date<=$today && $limit_hour<=$now) ? true : false;
        $year = ($current_month == '1') ? date('Y')+1 : date('Y');
        $humans = Members::actived()->get();
        $user = Members::find($id);
        $schedule = $user->dates->where('month', $current_month);
        if(count($schedule)!='0'){
            foreach ($schedule as $item) {
                // $item->shift = [ explode('-',$item->shift)[0], explode('-',$item->shift)[1]];
                $item->start = explode('-',$item->shift)[0];
                $item->end = explode('-',$item->shift)[1];
            }
        };
        $first_weekday_number = date('w', mktime(0, 0, 0, $current_month, 1, $year))-1;
        $days = date('t', strtotime($year.'-'.$current_month));
        $nav_hidden = 'hidden';
        return view('front.work.give_shift', compact('humans', 'user', 'schedule', 'days', 'month', 'current_month', 'year', 'first_weekday_number', 'not_limit', 'nav_hidden'));
    }

    public function save_shift($id, $month, Request $request)
    {
        $data = $request->all();
        $year = $data['year'];
        $month = $data['month'];
        $days = $data['days'];
        //date('w', mktime(0, 0, 0, $month, 3, $year)) -> 星期天是'0'
        for ($i=1; $i <= $days; $i++) { 
            $date = Dates::where('member_id', $id)->dates($year, $month, $i)->first();
            if($data[$i.'_started'] || $data[$i.'_ended']){
                //if has data
                $input_shift = $data[$i.'_started'].'-'.$data[$i.'_ended'];
                $weekday = date('w', mktime(0, 0, 0, $month, $i, $year));
                ( $weekday == '0' ) ? $weekday='7' : ''; //transfer to 7
                if($date){
                    //update
                    if($date->shift != $input_shift){
                        $date->update([
                            'shift' => $input_shift
                        ]);
                    }
                }else{
                    //create
                    Dates::create([
                        'member_id' => $id,
                        'year' => $year,
                        'month' => $month,
                        'day' => $i,
                        'shift' => $input_shift,
                        'week_id' => $weekday
                    ]);
                }
            }elseif($date){
                $date->delete();
            }
        }
        return redirect()->back();
    }

    public function shift_schedule(Request $request)
    {
        $month = $request->shift_month;
        $year = $request->shift_year;
        $days = date('t', strtotime($year.'-'.$month));
        for ($i=1; $i <= $days; $i++) {
            if(!Schedules::dates($year, $month, $i)->first()){
                $this->work($year, $month, $i);
            }
        }
        return redirect()->action('SchedulesController@admin_index');
        // return view('front.work.index');
    }

    public function work($year, $month, $day)
    {
        //normal shift array, can change!
        if(!!Dates::dates($year, $month, $day)->first()) {
            $weekday_range = unserialize(Dates::dates($year, $month, $day)->first()->weekday->range);

            $pt_dates = $this->buildPtDates($year, $month, $day);
            $ft_date = $this->buildFtDate($year, $month, $day);

            //only first condition!!!!!!!
            $result = $this->simpleLogic($pt_dates, $ft_date, $weekday_range[0]);
            $result ? $this->completeShift($result, 'create', $year, $month, $day) : '';
        }else{
            Schedules::create([
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'week_id' => date('w', mktime(0, 0, 0, $month, $day, $year)),
                'actived' => false,
                'shift' =>  'off'
            ]);
        }
    }
    
    protected function buildPtDates($year, $month, $day)
    {
        $dates = Dates::dates($year, $month, $day)->where('member_id', 'not like', '1')->get();
        $pt_dates = [];
        $i = 0;
        foreach ($dates as $date) {
            $duration = explode('-', $date->shift);
            $pt_dates[$i] = [
                'name' => $date->member()->first()->name,
                'duration' => [ $duration[0], $duration[1]]
            ];
            ++$i;
        }
        return $pt_dates;
    }

    protected function buildFtDate($year, $month, $day)
    {
        $date = Dates::dates($year, $month, $day)->where('member_id', 'like', '1')->first();
        if($date){
            $duration = explode('-', $date->shift);
            $ft_date = [
                'name' => $date->member()->first()->name,
                'duration' => [ $duration[0], $duration[1]]
            ];
            return $ft_date;
        }else{
            return null;
        }

    }

    protected function simpleLogic($pt_dates, $ft_date, $normal)
    {
        $shift = [];
        if ($ft_date) {
            if ($ft_date['duration'] == ['10', '18']) {
                array_push($shift, [
                    $ft_date['name'] => $ft_date['duration']
                ]);
                if (($key = array_search(['10', '18'], $normal)) !== false) {
                    unset($normal[$key]);
                }
            }
        }
        foreach ($normal as $item) {
            $suggest = $this->choosePt($pt_dates, $item);
            $result = $this->inputSuggest($shift, $suggest, $item, $pt_dates);
            $shift = $result[0];
            $pt_dates = $result[1];
        }
        return $shift;
    }

    protected function choosePt($pt_dates, $normal)
    {
        //choose a people for night shift
        $choose = [];
        foreach($pt_dates as $pt_date){
            $duration = $pt_date['duration'];
            if($duration[0]<=$normal[0] and $duration[1]>=$normal[1]){
                array_push($choose, $pt_date['name']);
            }
        }
        if(count($choose)>0){
            $n = random_int(0, count($choose)-1);
            return $choose[$n];
        }else{
            return null;
        }
    }

    protected function inputSuggest($shift, $suggest, $normal, $pt_dates)
    {
        if($suggest){
            array_push($shift, [
                $suggest => $normal
            ]);
            if (($key = array_search($suggest, array_column($pt_dates, 'name'))) !== false) {
                unset($pt_dates[$key]);
            }
        }else{
            array_push($shift, [
                'lack_human' => $normal
            ]);
        }
        return [$shift, $pt_dates];
    }

    protected function completeShift($result, $type, $year, $month, $day)
    {
        if($type == 'create'){
            $weekday = date('w', mktime(0, 0, 0, $month, $day, $year));
            ( $weekday == '0' ) ? $weekday='7' : ''; //transfer to 7
            Schedules::create([
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'week_id' => $weekday,
                'actived' => false,
                'shift' =>  serialize($result)
            ]);
        }else{
            $schedule = Schedule::dates($year, $month, $day)->first();
            if($schedule){
                $schedule->update([
                    'shift' =>  serialize($result)
                ]);
            }
        }
    }
}
