<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Customer;
use App\Models\Part;
use App\Models\Service;
use App\Models\Status;
use App\Models\StatusPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        // Eager load the related models (Service, Parts, and StatusPart)
        $approvals = Approval::with(['service', 'parts', 'parts.statusPart'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Sesuaikan dengan jumlah data per halaman yang diinginkan

        // Return view with the data
        return view('customer.approval.index', compact('approvals'));
    }



    public function create()
    {

        return view('customer.approval.create');
    }

    public function createApproval(Request $request)
    {
        try {
            // get the currently logged-in customer
            $customer = auth()->guard('customer')->user();

            // Validasi input
            $validatedData = $request->validate([
                'entry_ticket' => 'required|string|max:255',
                'request_date' => 'required|date',
                'approval_date' => 'nullable|date',
                'create_zulu_date' => 'nullable|date',
                'approval_area_remote_date' => 'nullable|date',
                'email_request' => 'nullable|string|max:255',
                'status_email_request' => 'nullable|string|max:255',
                'reason_description' => 'nullable|string|max:255',
                'part_number' => 'required|array',
                'status_part' => 'required|array',
                'status_part_used' => 'required|array',
                'SN_part_good' => 'nullable|array',
                'SN_part_bad' => 'nullable|array',
            ]);

             // Ambil service_id berdasarkan serial_number
             $service = Service::where('serial_number', $request->serial_number)->first();

             if (!$service) {
                 return redirect()->back()->with('error', 'Service with the given serial number not found.');
             }

            // Membuat Approval baru
            $approval = Approval::create([
                'customer_id' => $customer->customer_id,
                'service_id' => $service->service_id,
                'entry_ticket' => $request->entry_ticket,
                'request_date' => $request->request_date,
                'approval_date' => $request->approval_date,
                'create_zulu_date' => $request->create_zulu_date,
                'approval_area_remote_date' => $request->approval_area_remote_date,
                'email_request' => $request->email_request,
                'status_email_request' => $request->status_email_request,
                'reason_description' => $request->reason_description,
            ]);

            // Menghubungkan Part dan StatusPart ke Approval melalui tabel pivot
            foreach ($request->part_number as $index => $partNumber) {
                // Menyimpan atau menemukan Part berdasarkan part_number
                $part = Part::firstOrCreate([
                    'part_number' => $partNumber,
                ], [
                    'part_description' => 'Part description',
                    'part_type' => 'Part type',
                ]);

                // Membuat StatusPart baru
                $statusPart = StatusPart::create([
                    'SN_part_good' => $request->SN_part_good[$index],
                    'SN_part_bad' => $request->SN_part_bad[$index],
                    'status_part_used' => $request->status_part_used[$index],
                    'status_part' => $request->status_part[$index],
                ]);

                // Menyimpan hubungan di tabel pivot
                $approval->parts()->attach($part->part_id, [
                    'status_part_id' => $statusPart->status_part_id,
                ]);
            }

            return redirect()->back()->with('success', 'Approval created successfully!');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error creating approval: '.$e->getMessage(), [
                'request' => $request->all(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'An error occurred while creating approval. Please try again.');
        }
    }


    // NEED VALIDATE THIS CODE!!!!!
    public function showDetails(Request $request)
    {
        // Eager load the related models (service, status, parts)
        $query = Approval::with('service', 'status', 'parts');

        // Get the current logged-in customer
        $customer = auth()->guard('customer')->user();

        // Filter the query by customer_id
        $query->where('customer_id', $customer->customer_id);

        // Get the filtered approvals
        $approvals = $query->paginate(10);

        // Return the view with the approvals
        return view('customer.approval.details', compact('approvals', 'request'));
    }

    public function edit($approval_id)
    {
        // Find the approval by ID
        $approval = Approval::findOrFail($approval_id);

        // Return the view with the approval
        return view('customer.approval.edit', compact('approval'));
    }

    public function update(Request $request, $approval_id)
    {
        // Validate request with array input for part_number
        $request->validate([
            'entry_ticket' => 'required|unique:approvals,entry_ticket,' . $approval_id . ',approval_id',
            'serial_number' => 'required',
            'part_number.*' => 'required|exists:parts,part_number', // Validate each part number
            'request_date' => 'required',
        ]);

        // Find the approval by ID
        $approval = Approval::findOrFail($approval_id);

        // Find service based on serial number
        $service = Service::where('serial_number', $request->input('serial_number'))->first();
        if (!$service) {
            return redirect()->back()->with('error', 'Serial Number not found');
        }

        // Update status from request
        $status = $approval->status;
        $status->update([
            'status_part' => $request->status_part,
            'email_request' => $request->email_request,
            'status_email_request' => $request->status_email_request,
            'SN_part_good' => $request->SN_part_good,
            'SN_part_bad' => $request->SN_part_bad,
            'status_part_used' => $request->status_part_used,
            'reason_description' => $request->reason_description,
        ]);

        try {
            // Get the currently logged-in customer
            $customer = auth()->guard('customer')->user();

            // Update approval data
            $approval->update([
                'entry_ticket' => $request->entry_ticket,
                'request_date' => $request->request_date,
                'customer_id' => $customer->customer_id,
                'service_id' => $service->service_id,
                'approval_date' => $request->approval_date,
                'create_zulu_date' => $request->create_zulu_date,
                'approval_area_remote_date' => $request->approval_area_remote_date,
            ]);

            // Retrieve all part numbers from the request
            $partNumbers = $request->input('part_number', []);

            // Retrieve parts and prepare for syncing
            $parts = Part::whereIn('part_number', $partNumbers)->get();
            $partIds = $parts->pluck('part_id')->all();

            // Attach parts to the approval
            $approval->parts()->sync($partIds);

            return redirect()->route('customer.approval.details')->with('success', 'Approval updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function destroy($approval_id)
    {
        // Find the approval by ID
        $approval = Approval::findOrFail($approval_id);

        // Delete the approval
        $approval->delete();

        return redirect()->route('customer.approval.details')->with('success', 'Approval deleted successfully');
    }
}
