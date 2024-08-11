<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportService implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // log::debug('Importing row: ', $row);

        return Service::updateOrCreate(
            [
                'serial_number' => $row['serial_number'], // Kriteria pencarian berdasarkan serial_number
            ],
            [
                'bank_name' => $row['bank_name'],
                'machine_id' => $row['machine_id'],
                'machine_type' => $row['machine_type'],
                'service_center' => $row['service_center'],
                'location_name' => $row['location_name'],
                'partner_code' => $row['partner_code'],
                'spv_name' => $row['spv_name'],
                'fse_name' => $row['fse_name'],
                'fsl_name' => $row['fsl_name'],
            ]
        );
    }
}
