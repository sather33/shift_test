<?php

use Illuminate\Database\Seeder;
use App\Schedules;

class DefaultShopIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = Schedules::where('shop_id', '')->get();
        foreach ($schedules as $schedule) {
            $schedule->shop_id = 'L';
            $schedule->save();
        }
    }
}
