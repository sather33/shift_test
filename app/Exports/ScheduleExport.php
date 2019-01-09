<?php

namespace App\Exports;

use App\Schedules;
use Maatwebsite\Excel\Concerns\FromCollection;

class ScheduleExport implements FromCollection
{
  private $request;

  public function __construct($request)
  {
    $this->month = $request->month;
    $this->year  = $request->year;
  }

  public function collection()
  {
    $schedules = Schedules::where('year', $this->year)->where('month', $this->month)->get();
    foreach($schedules as $schedule){
      $shift = unserialize($schedule->shift);
      for ($i=0; $i < count($shift); $i++) { 
        $person = 'person_'.$i;
        $person_shift = 'person_'.$i.'_shift';
        $name = array_keys($shift[$i])[0];
        $schedule->$person = $name;
        $schedule->$person_shift = $shift[$i][$name][0].'-'.$shift[$i][$name][1];
      }
      unset($schedule->shift);
      unset($schedule->created_at);
      unset($schedule->updated_at);
      unset($schedule->week_id);
      unset($schedule->actived);
    }
    return $schedules; 
  }
}