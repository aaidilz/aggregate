<?php

namespace App\Imports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPart implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Part::updateOrCreate(
            [
                'part_number' => $row['part_number']
            ],
            [
                'part_description' => $row['part_description'],
                'part_type' => $row['part_type']
            ]
            );
    }
}
