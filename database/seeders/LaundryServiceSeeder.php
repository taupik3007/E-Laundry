<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaundryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laundry_services')->insert([
            [
                'lds_name' => 'Cuci Kering',
                'lds_image' => 'images/services/cuci_kering.png',
                'lds_sys_note' => 'Layanan cuci dan kering biasa',
                'lds_created_at' => now(),
                'lds_updated_at' => now(),
            ],
            [
                'lds_name' => 'Sofa',
                'lds_image' => 'images/services/sofa.png',
                'lds_sys_note' => 'Layanan cuci Sofa',
                'lds_created_at' => now(),
                'lds_updated_at' => now(),
            ],
        ]);
    }
}
