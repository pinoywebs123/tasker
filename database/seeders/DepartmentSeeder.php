<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name'=> 'Office of Instruction']);
        Department::create(['name'=> 'College of Computer Studies']);
        Department::create(['name'=> 'College of Arts and Sciences']);
        Department::create(['name'=> 'College of Engineering and Design']);
        Department::create(['name'=> 'College of Agriculture']);
    }
}
