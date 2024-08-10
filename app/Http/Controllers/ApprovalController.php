<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Customer;
use App\Models\Part;
use App\Models\Service;
use App\Models\Status;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
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
        return view('customer.approval.index', compact('approvals', 'request'));
    }



    public function create()
    {

        return view('customer.approval.create');

    }

    public function createApproval(Request $request)
    {
        // Validate request with array input for part_number
        $request->validate([
            'entry_ticket' => 'required|unique:approvals,entry_ticket',
            'serial_number' => 'required',
            'part_number.*' => 'required|exists:parts,part_number', // Validate each part number
            'request_date' => 'required',
        ]);

        // Check if entry ticket already exists
        $existingApproval = Approval::where('entry_ticket', $request->input('entry_ticket'))->first();
        if ($existingApproval) {
            return redirect()->back()->with('error', 'Entry Ticket already exists');
        }

        // Find service based on serial number
        $service = Service::where('serial_number', $request->input('serial_number'))->first();
        if (!$service) {
            return redirect()->back()->with('error', 'Serial Number not found');
        }

        // Store status from request
        $status = Status::create([
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

            // Store approval data
            $approval = Approval::create([
                'entry_ticket' => $request->entry_ticket,
                'request_date' => $request->request_date,
                'customer_id' => $customer->customer_id,
                'service_id' => $service->service_id,
                'status_id' => $status->status_id,
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

            return redirect()->route('customer.approval.index')->with('success', 'Approval created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

}
