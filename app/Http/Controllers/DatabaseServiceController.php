<?php

namespace App\Http\Controllers;

use App\Exports\ExportTemplateService;
use App\Models\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $PartnerCodes = Service::select('partner_code')->distinct()->get();
        $ServiceCenters = Service::select('service_center')->distinct()->get();
        $BankNames = Service::select('bank_name')->distinct()->get();

        return view('customer.database.services.index', compact('services', 'machineTypes', 'FSENames', 'SPVNames', 'PartnerCodes', 'ServiceCenters', 'BankNames', 'request'));
    }

    // IMPORT SECTION
    public function showImportForm()
    {
        return view('customer.database.services.import.index');
    }

    public function import(Request $request)
    {
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

        // Import data dari file excel
        // continue here....
    }


    // EXPORT SECTION
    public function exportTemplate()
    {
        return Excel::download(new ExportTemplateService, 'service_template.xlsx');
    }
}
