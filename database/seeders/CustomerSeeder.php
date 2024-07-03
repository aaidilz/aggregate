<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'customer_id' => Str::uuid(),
                'username' => 'customer',
                'password' => Hash::make('customer'),
                'nama_customer' => 'Customer',
                'email' => 'customer@mail.com',
            ],
        ];

        DB::table('customer')->insert($customers);
    }
}
