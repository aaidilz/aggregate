<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportPartData implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Part::select('part_number', 'part_description', 'part_type')->get();
    }


    public function headings(): array
    {
        return [
            'Part Number',
            'Part Description',
            'Part Type',
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
