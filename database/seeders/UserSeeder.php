<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@yahoo.com',
            'password'      => bcrypt('admin123'),
            'position_id'    => 1,
            'department_id' => 1
        ]);

        $admin->assignRole('admin');

        $manager = User::create([
            'name'      => 'Manager',
            'email'     => 'manager@yahoo.com',
            'password'  => bcrypt('manager123'),
            'position_id'    => 2,
            'department_id' => 2
        ]);

        $manager->assignRole('manager');

        $tasker = User::create([
            'name'      => 'Tasker',
            'email'     => 'tasker@yahoo.com',
            'password'  => bcrypt('tasker123'),
            'position_id'    => 3,
            'department_id' => 3
        ]);

        $tasker->assignRole('tasker');

    }
}
