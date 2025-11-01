<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::create([
            'usr_name' => 'Lay Zhang',
            'usr_nik' => '3271020101010001',
            'usr_email' => 'rwleader@gmail.com',
            'password' => bcrypt(123456789)
        ]);
        $customer->assignRole('customer');

    }
}
