<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'ord_user_id' => 1, // pastikan user id 1 ada
                'ord_name_user' => 'Budi Santoso',
                'ord_phone_number' => '081234567890',
                'ord_subdistrict' => 'Garut Kota',
                'ord_adress_detail' => 'Jl. Ahmad Yani No. 45',
                'ord_packages_id' => 1,
                'ord_pickup_address' => 'Jl. Ahmad Yani No. 45',
                'ord_pickup_schedule' => '2025-11-08 09:00:00',
                'ord_delivery_schedule' => '2025-11-09 15:00:00',
                'ord_total_weight' => 5,
                'ord_status' => 'Menunggu',
                'ord_total_price' => 75000,
                'ord_pickup_courier_id' => null,
                'ord_delivery_courier_id' => null,
                'ord_order_code' => 'ORD-001',
                'ord_sys_note' => 'Order pertama pelanggan Budi',
                'ord_created_at' => now(),
                'ord_updated_at' => now(),
            ],
            [
                'ord_user_id' => 1,
                'ord_name_user' => 'Budi Santoso',
                'ord_phone_number' => '081234567890',
                'ord_subdistrict' => 'Garut Kota',
                'ord_adress_detail' => 'Jl. Ahmad Yani No. 45',
                'ord_packages_id' => 2,
                'ord_pickup_address' => 'Jl. Ahmad Yani No. 45',
                'ord_pickup_schedule' => '2025-11-09 10:00:00',
                'ord_delivery_schedule' => '2025-11-12 15:00:00',
                'ord_total_weight' => 7,
                'ord_status' => 'Selesai',
                'ord_total_price' => 70000,
                'ord_pickup_courier_id' => null,
                'ord_delivery_courier_id' => null,
                'ord_order_code' => 'ORD-002',
                'ord_sys_note' => 'Order kedua belum selesai',
                'ord_created_at' => now(),
                'ord_updated_at' => now(),
            ],
        ]);
    }
}
