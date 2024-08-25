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
        // Ambil customer_id dari request (misalnya dari URL query string)
        $customer_id = $request->input('customer_id');

        // Eager load the related models (Service, Parts, and StatusPart)
        $query = Approval::with(['service', 'parts', 'parts.statusPart'])
            ->orderBy('created_at', 'desc');

        // Jika customer_id ada, filter berdasarkan customer_id
        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        } else {
            // Jika tidak ada customer_id, ambil customer_id dari customer yang sedang login
            $customer = auth()->guard('customer')->user();
            $query->where('customer_id', $customer->customer_id);
        }

        // Paginate hasil query
        $approvals = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman yang diinginkan

        // Return view with the data
        return view('customer.approval.index', compact('approvals'));
    }

    public function create()
    {

        return view('customer.approval.create');
    }

    public function createApproval(Request $request)
    {
        // dd($request->all());
        try {
            // Mendapatkan customer yang sedang login
            $customer = auth()->guard('customer')->user();

            // Validasi input
            $validatedData = $request->validate([
                'entry_ticket' => 'required|string|max:255|unique:approvals,entry_ticket',
                'request_date' => 'required|date',
                'approval_date' => 'nullable|date',
                'create_zulu_date' => 'nullable|date',
                'approval_area_remote_date' => 'nullable|date',
                'email_request' => 'nullable|string|max:255',
                'status_email_request' => 'nullable|string|max:255',
                'reason_description' => 'nullable|string|max:255',
                'part_number' => 'required|array|exists:parts,part_number',
                'status_part' => 'required|array',
                'status_part_used' => 'required|array',
                'SN_part_good' => 'nullable|array',
                'SN_part_bad' => 'nullable|array',
                'serial_number' => 'required|string|exists:services,serial_number', // Pastikan serial_number disertakan
            ]);

            // Mendapatkan service_id berdasarkan serial_number
            $service = Service::where('serial_number', $validatedData['serial_number'])->firstOrFail();

            // Membuat Approval baru
            $approval = Approval::create([
                'customer_id' => $customer->customer_id,
                'service_id' => $service->service_id,
                'entry_ticket' => $validatedData['entry_ticket'],
                'request_date' => $validatedData['request_date'],
                'approval_date' => $validatedData['approval_date'],
                'create_zulu_date' => $validatedData['create_zulu_date'],
                'approval_area_remote_date' => $validatedData['approval_area_remote_date'],
                'email_request' => $validatedData['email_request'],
                'status_email_request' => $validatedData['status_email_request'],
                'reason_description' => $validatedData['reason_description'],
            ]);

            // Menghubungkan Part dan StatusPart ke Approval melalui tabel pivot
            foreach ($validatedData['part_number'] as $index => $partNumber) {

                // Skip jika part_number null atau kosong
                if (!$partNumber) {
                    continue;
                }

                // Menyimpan atau menemukan Part berdasarkan part_number
                $part = Part::firstOrCreate([
                    'part_number' => $partNumber,
                ], [
                    'part_description' => 'Part description', // Ubah jika perlu menjadi dynamic
                    'part_type' => 'Part type', // Ubah jika perlu menjadi dynamic
                ]);

                // Membuat StatusPart baru
                $statusPart = StatusPart::create([
                    'SN_part_good' => $validatedData['SN_part_good'][$index] ?? null,
                    'SN_part_bad' => $validatedData['SN_part_bad'][$index] ?? null,
                    'status_part_used' => $validatedData['status_part_used'][$index],
                    'status_part' => $validatedData['status_part'][$index],
                ]);

                // Menyimpan hubungan di tabel pivot
                $approval->parts()->attach($part->part_id, [
                    'status_part_id' => $statusPart->status_part_id,
                ]);
            }

            return redirect()->back()->with('success', 'Approval created successfully!');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to create approval: ';

            // Cek jika error merupakan instance dari ValidationException
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->validator->errors()->all();
                $errorMessage .= implode(' ', $errors); // Gabungkan semua pesan error menjadi satu string
            } else {
                // Tambahkan pesan error dari exception lainnya
                $errorMessage .= $e->getMessage();
            }

            // Log error untuk debugging
            Log::error('Error creating approval: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function showDetails(Request $request)
    {
        $customer_id = $request->input('customer_id');

        $query = Approval::with(['service', 'parts', 'parts.statusPart'])
            ->orderBy('created_at', 'desc');

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        } else {
            $customer = auth()->guard('customer')->user();
            $query->where('customer_id', $customer->customer_id);
        }

        $approvals = $query->paginate(10);

        return view('customer.approval.details', compact('approvals'));

    }

    public function editApproval($approval_id)
    {
        // Check if the customer is logged in
        $customer = auth()->guard('customer')->user();
        if (!$customer) {
            // Return JSON response for unauthorized access
            return response()->json(['error' => 'You are not authorized to access this page'], 403);
        }

        // Find the approval record or fail
        $approval = Approval::with(['service', 'parts', 'parts.statusPart'])
                            ->findOrFail($approval_id);

        // Check if the approval belongs to the logged-in customer
        if ($approval->customer_id !== $customer->customer_id) {
            // Return JSON response for forbidden access
            return response()->json(['error' => 'You do not have permission to edit this approval'], 403);
        }

        // Return the approval data as JSON if needed, or proceed with view rendering
        return view('customer.approval.edit', compact('approval'));
    }


    public function updateApproval(Request $request, $approval_id)
    {
        dd($request->all());
        // Check if the customer is logged in
        $customer = auth()->guard('customer')->user();
        if (!$customer) {
            // Return JSON response for unauthorized access
            return response()->json(['error' => 'You are not authorized to access this page'], 403);
        }

        // Find the approval record or fail
        $approval = Approval::with(['service', 'parts', 'parts.statusPart'])
                            ->findOrFail($approval_id);

        // Check if the approval belongs to the logged-in customer
        if ($approval->customer_id !== $customer->customer_id) {
            // Return JSON response for forbidden access
            return response()->json(['error' => 'You do not have permission to edit this approval'], 403);
        }

        try {
            // Validate the input data
            $validatedData = $request->validate([
                'entry_ticket' => 'required|string|max:255|unique:approvals,entry_ticket,' . $approval->approval_id . ',approval_id',
                'request_date' => 'required|date',
                'approval_date' => 'nullable|date',
                'create_zulu_date' => 'nullable|date',
                'approval_area_remote_date' => 'nullable|date',
                'email_request' => 'nullable|string|max:255',
                'status_email_request' => 'nullable|string|max:255',
                'reason_description' => 'nullable|string|max:255',
                'part_number' => 'required|array|exists:parts,part_number',
                'status_part' => 'required|array',
                'status_part_used' => 'required|array',
                'SN_part_good' => 'nullable|array',
                'SN_part_bad' => 'nullable|array',
                'serial_number' => 'required|string|exists:services,serial_number', // Make sure serial_number is included
            ]);

            // Update the approval record
            $approval->update([
                'entry_ticket' => $validatedData['entry_ticket'],
                'request_date' => $validatedData['request_date'],
                'approval_date' => $validatedData['approval_date'],
                'create_zulu_date' => $validatedData['create_zulu_date'],
                'approval_area_remote_date' => $validatedData['approval_area_remote_date'],
                'email_request' => $validatedData['email_request'],
                'status_email_request' => $validatedData['status_email_request'],
                'reason_description' => $validatedData['reason_description'],
            ]);

            // Update the related parts and status parts
            $approval->parts()->detach();

            foreach ($validatedData['part_number'] as $index => $partNumber) {
                // Skip if part_number is null or empty
                if (!$partNumber) {
                    continue;
                }

                // Save or find the Part based on part_number
                $part = Part::firstOrCreate([
                    'part_number' => $partNumber,
                ], [
                    'part_description' => 'Part description', // Change if needed to be dynamic
                    'part_type' => 'Part type', // Change if needed to be dynamic
                ]);

                // Create a new StatusPart
                $statusPart = StatusPart::create([
                    'SN_part_good' => $validatedData['SN_part_good'][$index] ?? null,
                    'SN_part_bad' => $validatedData['SN_part_bad'][$index] ?? null,
                    'status_part_used' => $validatedData['status_part_used'][$index],
                    'status_part' => $validatedData['status_part'][$index],
                ]);

                // Save the relationship in the pivot table
                $approval->parts()->attach($part->part_id, [
                    'status_part_id' => $statusPart->status_part_id,
                ]);
            }

            return redirect()->back()->with('success', 'Approval updated successfully!');

        } catch (\Exception $e) {
            $errorMessage = 'Failed to update approval: ';

            // Check if the error is an instance of ValidationException
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->validator->errors()->all();
                $errorMessage .= implode(' ', $errors); // Combine all error messages into one string
            } else {
                // Add error message from other exceptions
                $errorMessage .= $e->getMessage();
            }

            // Log the error for debugging
            Log::error('Error updating approval: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', $errorMessage);
        }

    }
}
