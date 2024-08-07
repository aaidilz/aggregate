<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ExportTemplateService implements WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'serial_number',
            'machine_type',
            'service_center',
            'partner_code',
            'spv_name',
            'fse_name',
            'bank_name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling the header row
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }
}
