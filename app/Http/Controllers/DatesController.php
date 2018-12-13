<?php

namespace App\Http\Controllers;

use App\Dates;
use App\Schedules;
use App\Members;
use Illuminate\Http\Request;

class DatesController extends Controller
{
    public function give_shift($id, $month)
    {
        // $month = ($month == '12') ? '1' : date('n')+1;
        // $month = '11';
        $year = ($month == '1') ? date('Y')+1 : date('Y');
        $humans = Members::actived()->get();
        $user = Members::find($id);
        $schedule = $user->dates->where('month', $month);
        if(count($schedule)!='0'){
            foreach ($schedule as $item) {
                // $item->shift = [ explode('-',$item->shift)[0], explode('-',$item->shift)[1]];
                $item->start = explode('-',$item->shift)[0];
                $item->end = explode('-',$item->shift)[1];
            }
        };
        $first_weekday_number = date('w', mktime(0, 0, 0, $month, 1, $year))-1;
        $days = date('t', strtotime($year.'-'.$month));
        return view('front.work.give_shift', compact('humans', 'user', 'schedule', 'days', 'month', 'year', 'first_weekday_number'));
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
        // $normal = ['10', '24'];
        // $year = '2018';
        // $month = '11';
        // $day = '1';
        $weekday_range = unserialize(Dates::dates($year, $month, $day)->first()->weekday->range);

        $pt_dates = $this->buildPtDates($year, $month, $day);
        $ft_date = $this->buildFtDate($year, $month, $day);
        // $is_matched = $this->matchToNormal($pt_dates, $ft_date, $normal);
        
        // if($is_matched){
            // if(count($weekday_range)=='1'){
                //only first conditino!!!!!!!
                $result = $this->simpleLogic($pt_dates, $ft_date, $weekday_range[0]);
                $result ? $this->completeShift($result, 'create', $year, $month, $day) : '';
            // }
        // }
        // dd('bad');
        // dd(array_udiff($result, $normal));
        //five people
        //chole = [10~18]
        //green = [10~18]
        //johnny = [10~18]
        //tee = [15~24]
        //min = [18~24]
        // $return = $weekday_range[0];
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

    // protected function matchToNormal($pt_dates, $ft_date, $normal)
    // {
    //     $result = [];
    //     if($ft_date){
    //         $result = [ $ft_date['duration'][0], $ft_date['duration'][1]];
    //         for( $i= 0; $i < count($pt_dates); ++$i){
    //             $result = [
    //                 '0' => ($pt_dates[$i]['duration'][0]<$result[0]) ? $pt_dates[$i]['duration'][0] : $result[0],
    //                 '1' => ($pt_dates[$i]['duration'][1]>$result[1]) ? $pt_dates[$i]['duration'][1] : $result[1],
    //             ];
    //         }
    //     }else{
    //         $result = [ $pt_dates['0']['duration'][0], $pt_dates['0']['duration'][1]];
    //         for( $i= 1; $i < count($pt_dates); ++$i){
    //             $result = [
    //                 '0' => ($pt_dates[$i]['duration'][0]<$result[0]) ? $pt_dates[$i]['duration'][0] : $result[0],
    //                 '1' => ($pt_dates[$i]['duration'][1]>$result[1]) ? $pt_dates[$i]['duration'][1] : $result[1],
    //             ];
    //         }
    //     }
    //     return $result == $normal;
    // }

    protected function simpleLogic($pt_dates, $ft_date, $normal)
    {
        // normal = [ ['10', '18'], ['18', '24'] ]
        // default $ft_date == ['10', '18']
        $shift = [];
        if ($ft_date) {
            if ($ft_date['duration'] == ['10', '18']) {
                array_push($shift, [
                    $ft_date['name'] => $ft_date['duration']
                ]);
                // $normal = ['18', '24'];
                //choose a people for night shift
                // $suggest = $this->choosePt($pt_dates, $normal);
                // $shift = $this->inputSuggest($shift, $suggest, $normal);
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
            // $normal_1 = ['10', '18'];
            // $normal_2 = ['18', '24'];

            // $suggest_1 = $this->choosePt($pt_dates, $normal_1);
            // $suggest_2 = $this->choosePt($pt_dates, $normal_2);
            // $shift = $this->inputSuggest($shift, $suggest_1, $normal_1);
            // $shift = $this->inputSuggest($shift, $suggest_2, $normal_2);
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
