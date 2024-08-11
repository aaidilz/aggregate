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
            // Styling the header row
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }
}
