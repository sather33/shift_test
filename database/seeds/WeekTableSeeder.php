<?php

use Illuminate\Database\Seeder;
use App\Week;
use function Opis\Closure\serialize;

class WeekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Week::create([
            'name' => 'Monday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
              ]) 
        ]);

        Week::create([
            'name' => 'Tuesday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
              ])
        ]);
        Week::create([
            'name' => 'Wednesday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
                [
                  [
                    "10",
                    "14",
                  ],
                  [
                    "14",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
                [
                  [
                    "10",
                    "15",
                  ],
                  [
                    "15",
                    "19",
                  ],
                  [
                    "19",
                    "24",
                  ],
                ],
              ])
        ]);
        Week::create([
            'name' => 'Thursday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
              ])
        ]);
        Week::create([
            'name' => 'Firday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "22",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
                [
                  [
                    "10",
                    "15",
                  ],
                  [
                    "12",
                    "20",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
              ])
        ]);
        Week::create([
            'name' => 'Saturday',
            'range' => serialize([
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                  [
                    "11",
                    "15",
                  ],
                  [
                    "18",
                    "22",
                  ],
                ],
                [
                  [
                    "10",
                    "15",
                  ],
                  [
                    "12",
                    "20",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
              ])
        ]);
        Week::create([
            'name' => 'Sunday',
            'range' => serialize([
                [
                  [
                    "10",
                    "15",
                  ],
                  [
                    "12",
                    "20",
                  ],
                  [
                    "18",
                    "24",
                  ],
                ],
                [
                  [
                    "10",
                    "18",
                  ],
                  [
                    "18",
                    "24",
                  ],
                  [
                    "11",
                    "15",
                  ],
                ],
              ])
        ]);
    }
}
