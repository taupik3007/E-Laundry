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
            'email' => 'zhangyixing@gmail.com',
            'password' => bcrypt(123456789),
            'usr_birthplace' => 'Bandung',
            'usr_birthdate' => '1991-10-03',
            'usr_gender' => 'laki-laki',
            'usr_religion' => 'Kristen',
            'usr_telephone' => '082123456789',
        ]);
        $customer->assignRole('customer');

        
        $customer1 = User::create([
            'usr_name' => 'Eka Wariah',
            'usr_nik' => '3271020101010001',
            'email' => 'ekawrh11@gmail.com',
            'password' => bcrypt(123456789),
            'usr_birthplace' => 'Bandung',
            'usr_birthdate' => '2002-12-28',
            'usr_gender' => 'Perempuan',
            'usr_religion' => 'Islam',
            'usr_telephone' => '082123456789',
        ]);
        $customer1->assignRole('customer');


        $employee1 = User::create([
            'usr_name' => 'Raneu Aprianti',
            'usr_nik' => '3271020101010001',
            'email' => 'raneuaprianti@gmail.com',
            'password' => bcrypt(123456789),
            'usr_birthplace' => 'Garut',
            'usr_birthdate' => '2002-12-28',
            'usr_gender' => 'Perempuan',
            'usr_religion' => 'Islam',
            'usr_telephone' => '082123456789',
        ]);
        $employee1->assignRole('employee');

    }
}
