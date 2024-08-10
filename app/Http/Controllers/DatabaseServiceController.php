<?php

namespace App\Http\Controllers;

use App\Exports\ExportServiceData;
use App\Exports\ExportTemplateService;
use App\Imports\ImportService;
use App\Models\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DatabaseServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('serial_number')) {
            $query->where('serial_number', 'like', '%' . $request->input('serial_number') . '%');
        }

        if ($request->filled('machine_id')) {
            $query->where('machine_id', 'like', '%' . $request->input('machine_id') . '%');
        }

        if ($request->filled('machine_type')) {
            $query->where('machine_type', 'like', '%' . $request->input('machine_type') . '%');
        }

        if ($request->filled('service_center')) {
            $query->where('service_center', 'like', '%' . $request->input('service_center') . '%');
        }

        if ($request->filled('partner_code')) {
            $query->where('partner_code', 'like', '%' . $request->input('partner_code') . '%');
        }

        if ($request->filled('spv_name')) {
            $query->where('spv_name', 'like', '%' . $request->input('spv_name') . '%');
        }

        if ($request->filled('fse_name')) {
            $query->where('fse_name', 'like', '%' . $request->input('fse_name') . '%');
        }

        $services = $query->paginate(10);
        $machineTypes = Service::select('machine_type')->distinct()->get();
        $FSENames = Service::select('fse_name')->distinct()->get();
        $SPVNames = Service::select('spv_name')->distinct()->get();
        $partnerCodes = Service::select('partner_code')->distinct()->get();
        $serviceCenters = Service::select('service_center')->distinct()->get();
        $bankNames = Service::select('bank_name')->distinct()->get();

        return view('customer.database.services.index', compact('services', 'machineTypes', 'FSENames', 'SPVNames', 'partnerCodes', 'serviceCenters', 'bankNames', 'request'));
    }

    // IMPORT SECTION
    public function showImportForm()
    {
        return view('customer.database.services.import.index');
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
            'bank_name',
            'machine_id',
            'machine_type',
            'service_center',
            'location_name',
            'partner_code',
            'spv_name',
            'fse_name',
            'fsl_name'
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
            Excel::import(new ImportService, $request->file('file'));
            return redirect()->back()
                ->with('success', 'Data Part berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Data Part gagal diimport, pastikan file yang diupload sesuai dengan format yang ditentukan');
        }
    }


    // EXPORT SECTION
    public function exportTemplate()
    {
        return Excel::download(new ExportTemplateService, 'service_template.xlsx');
    }

    public function export()
    {
        return Excel::download(new ExportServiceData, 'service.xlsx');
    }
}
