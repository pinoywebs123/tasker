<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = User::create([
            'first_name'    => 'Sharmaine',
            'last_name'     => 'Limited',
            'username'      => 'sharmaine.limited',
            'email'     => 'manager2@yahoo.com',
            'password'  => bcrypt('manager123'),
            'position_id'    => 2,
            'department_id' => 2
        ]);

        $manager->assignRole('manager_limited');
    }
}
