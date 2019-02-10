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
        $weekName = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Firday', 'Saturday', 'Sunday'];
        foreach ($weekName as $day) {
          Week::create([
            'shop_id' => 'Y',
            'name' => $day,
            'range' => serialize([
              [
                [10, 24]
              ],
            ])
          ]);
        }
        foreach ($weekName as $day) {
          Week::create([
            'shop_id' => 'A',
            'name' => $day,
            'range' => serialize([
              [
                [10.5, 24]
              ],
            ])
          ]);
        }

    }
}
