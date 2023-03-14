<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'a',
            'last_name' => 'b',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'phone' => '151561651',
            'address' => 'a',
            'country_id' => 1,
            'province_id' => 2,
            'city_id' => 3,
            'consent_to_receive_newsletter' => false,
            'business' => false
        ])->assignRole('Admin'); 
    }
}
