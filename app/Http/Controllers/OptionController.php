<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\Members;
use App\Month;
use App\Schedules;

class OptionController extends Controller
{
    public function setting()
    {
        $humans= Members::actived()->get();
        $month = Month::find(1) ? Month::find(1)->number : null;
        $current_dates = date('t');
        $member_total = null;
        $option = Option::find(1);
        $schedules = Schedules::where('day', '1')->get();
        return view('front.work.setting', compact('humans', 'month', 'member_total', 'current_dates', 'option', 'schedules'));
    }

    public function save_setting(Request $request)
    {
        $month = Month::find(1);
        if($month){
            $month->update([
                'number' => $request->month
            ]);
        }else{
            Month::create([
                'number' => $request->month
            ]);
        }
        return redirect()->back();
    }

    public function limit(Request $request){
        $option = Option::find(1);
        if( $option ){
            $option->update([
                'limit_date' => $request->limit_date,
                'limit_hour' => $request->limit_hour,
            ]);
        }else{
            Option::create([
                'limit_date' => $request->limit_date,
                'limit_hour' => $request->limit_hour,
            ]);
        }
        return redirect()->back();
    }
}
