<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        Position::create(['name'=> 'Director']);
        Position::create(['name'=> 'Secretary']);
        Position::create(['name'=> 'Office Assistant']);
        Position::create(['name'=> 'College Dean']);
        Position::create(['name'=> 'Department Chairperson']);
        Position::create(['name'=> 'Faculty']);
    }
}
