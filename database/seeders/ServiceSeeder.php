<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_id' => Str::uuid(),
                'bank_name' => 'Bank Mandiri',
                'serial_number' => '1234567890',
                'machine_id' => '1234567890',
                'machine_type' => 'ATM',
                'service_center' => 'Jakarta',
                'location_name' => 'Jakarta Pusat',
                'partner_code' => '1234567890',
                'spv_name' => 'Supervisor',
                'fse_name' => 'Field Service Engineer',
                'fsl_name' => 'Field Service Leader',
            ],
            [
                'service_id' => Str::uuid(),
                'bank_name' => 'Bank BCA',
                'serial_number' => '0987654321',
                'machine_id' => '0987654321',
                'machine_type' => 'ATM',
                'service_center' => 'Jakarta',
                'location_name' => 'Jakarta Barat',
                'partner_code' => '0987654321',
                'spv_name' => 'Supervisor',
                'fse_name' => 'Field Service Engineer',
                'fsl_name' => 'Field Service Leader',
            ],
        ];

        DB::table('services')->insert($services);
    }
}
