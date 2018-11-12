<?php

use Illuminate\Database\Seeder;
use App\Members;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Members::create([
            'name' => 'Green'
        ]);
        Members::create([
            'name' => 'Kelly'
        ]);
        Members::create([
            'name' => 'Johnny'
        ]);
        Members::create([
            'name' => 'Nicole'
        ]);
        Members::create([
            'name' => 'Corn'
        ]);
    }
}
