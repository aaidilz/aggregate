<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'admin_id' => Str::uuid(),
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'nama_admin' => 'Admin',
                'email' => 'admin@mail.com',
            ],
        ];

        DB::table('admin')->insert($admins);
    }
}
