<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportServiceData implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Service::select(
            'bank_name',
            'serial_number',
            'machine_id',
            'machine_type',
            'service_center',
            'location_name',
            'partner_code',
            'spv_name',
            'fse_name',
            'fsl_name',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Bank Name',
            'Serial Number',
            'Machine ID',
            'Machine Type',
            'Service Center',
            'Location Name',
            'Partner Code',
            'SPV Name',
            'FSE Name',
            'FSL Name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                'font' => ['normal' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => 'left',
                    'vertical' => 'center'
                ]
            ],
        ];
    }
}
