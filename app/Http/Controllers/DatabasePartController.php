<?php

namespace App\Http\Controllers;

use App\Exports\ExportTemplatePart;
use App\Imports\ImportPart;
use App\Models\Part;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DatabasePartController extends Controller
{
    public function index()
    {
        $parts = Part::Paginate(10);
        $partTypes = Part::select('part_type')->distinct()->get();
        return view('customer.database.parts.index', compact('parts', 'partTypes'));
    }

    // IMPORT SECTION
    public function showImportForm()
    {
        return view('customer.database.parts.import.index');
    }

    public function import(Request $request)
    {
        // Validasi file upload
        $request->validate(
            [
                'file' => 'required|mimes:xlsx,xls'
            ],
            [
                'file.required' => 'File yang diunggah tidak boleh kosong',
                'file.mimes' => 'File yang diunggah harus berformat .xlsx atau .xls'
            ]
        );

        // Mendapatkan ekstensi file yang diunggah
        $extension = $request->file('file')->getClientOriginalExtension();

        if (!in_array($extension, ['xlsx', 'xls'])) {
            return redirect()->back()->with('error', 'File yang diunggah tidak memiliki ekstensi yang valid. Hanya file dengan ekstensi .xlsx atau .xls yang diizinkan.');
        }

        // Mendefinisikan heading yang dibutuhkan
        $requiredHeadings = [
            'part_number',
            'part_description',
            'part_type'
        ];

        // Mengambil heading dari file Excel
        $headings = (new HeadingRowImport)->toArray($request->file('file'))[0][0];

        // Memeriksa apakah semua heading yang dibutuhkan ada dalam file
        foreach ($requiredHeadings as $requiredHeading) {
            if (!in_array($requiredHeading, $headings)) {
                return redirect()->back()
                    ->with('error', 'Data Part gagal diimport, pastikan file yang diupload sesuai dengan format template yang ditentukan');
            }
        }

        // Proses import dengan Excel
        try {
            Excel::import(new ImportPart, $request->file('file'));
            return redirect()->back()
                ->with('success', 'Data Part berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Data Part gagal diimport, pastikan file yang diupload sesuai dengan format yang ditentukan');
        }
    }

    public function exportTemplate()
    {
        return Excel::download(new ExportTemplatePart, 'template_part.xlsx');
    }

    // EXPORT SECTION


}
