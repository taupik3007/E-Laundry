<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaundryPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laundry_packages')->insert([
            [
                'ldp_service_id' => 1, // FK ke laundry_services
                'ldp_name' => 'Paket Express',
                'ldp_description' => 'Selesai dalam 1 hari',
                'ldp_duration' => '1 Hari',
                'ldp_price' => 15000,
                'ldp_sys_note' => 'Paket cepat untuk kebutuhan mendesak',
                'ldp_created_at' => now(),
                'ldp_updated_at' => now(),
            ],
            [
                'ldp_service_id' => 2,
                'ldp_name' => 'Paket Hemat',
                'ldp_description' => 'Selesai dalam 3 hari',
                'ldp_duration' => '3 Hari',
                'ldp_price' => 10000,
                'ldp_sys_note' => 'Paket ekonomis untuk cuci rutin',
                'ldp_created_at' => now(),
                'ldp_updated_at' => now(),
            ],
        ]);
    }
}
