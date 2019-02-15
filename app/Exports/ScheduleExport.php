<?php

namespace App\Exports;

use App\Schedules;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ScheduleExport implements WithMultipleSheets
{
  use Exportable;
  private $request;

  public function __construct($request)
  {
    $this->year = $request->year;
    $this->month = $request->month;
  }

  public function sheets() : array
  {
    $sheets = [];
    $sheets[] = new SchedulePerShop($this->year, $this->month, $shopId = 'Y');
    $sheets[] = new SchedulePerShop($this->year, $this->month, $shopId = 'A');
    return $sheets;
  }
}