<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ExportTemplatePart implements WithHeadings, WithStyles
{
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
            // Styling the header row
            1    => ['font' => ['normal' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }
}
