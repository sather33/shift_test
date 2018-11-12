<?php

use Illuminate\Database\Seeder;
use App\Month;

class CreateMonthTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Month::create([
            'number' => '12'
        ]);
    }
}
