<?php

namespace App\Exports;

use App\Schedules;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class SchedulePerShop implements FromCollection, WithTitle
{
  private $request;

  public function __construct($year, $month, $shopId)
  {
    $this->year = $year;
    $this->month = $month;
    $this->shopId = $shopId;
  }

  public function collection()
  {
    $schedules = Schedules::where('shop_id', $this->shopId)->where('year', $this->year)->where('month', $this->month)->get();
    foreach ($schedules as $schedule) {
      if ($schedule->shift !== 'off') {
        $shift = unserialize($schedule->shift);
        for ($i = 0; $i < count($shift); $i++) {
          $person = 'person_' . $i;
          $person_shift = 'person_' . $i . '_shift';
          $name = array_keys($shift[$i])[0];
          $schedule->$person = $name;
          $schedule->$person_shift = $shift[$i][$name][0] . '-' . $shift[$i][$name][1];
        }
      }
      unset($schedule->shift);
      unset($schedule->created_at);
      unset($schedule->updated_at);
      unset($schedule->week_id);
      unset($schedule->actived);
    }
    return $schedules;
  }

  public function title() : string
  {
    if ($this->shopId === 'Y') {
      return '延吉店班表';
    }
    return '安東店班表';
  }
}