<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            LaundryServiceSeeder::class,
            LaundryPackageSeeder::class,
            // OrderSeeder::class

        ]);
        $owner2 = User::create([
            'usr_name' => 'Owner',
            'usr_nik' => '3201234567891234',
            'email' => 'owner12311@gmail.com',
            'password' => bcrypt("owner12311"),
            'usr_birthplace' => 'Bandung',
            'usr_birthdate' => '2003-7-30',
            'usr_gender' => 'Perempuan',
            'usr_religion' => 'Islam',
            'usr_telephone' => '085864296238',
        ]);
        $owner2->assignRole('owner');
    }
}
