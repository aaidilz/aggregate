<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parts = [
            [
                'part_id' => Str::uuid(),
                'part_number' => '123456',
                'part_description' => 'Part 1',
                'part_type' => 'Type 1',
            ],
            [
                'part_id' => Str::uuid(),
                'part_number' => '654321',
                'part_description' => 'Part 2',
                'part_type' => 'Type 2',
            ],
        ];

        DB::table('parts')->insert($parts);
    }
}
