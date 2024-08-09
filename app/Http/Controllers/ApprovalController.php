<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(request $request)
    {
        $query = Approval::with('customers', 'service', 'status', 'parts');

        if ($request->filled('entry_ticket')) {
            $query->where('entry_ticket', 'like', '%' . $request->input('entry_ticket') . '%');
        }

        $approvals = $query->paginate(10);

        return view('customer.approval.index', compact('approvals', 'request'));
    }

    public function create()
    {
        return view('customer.approval.create');
    }

    public function createApproval(Request $request)
    {
        $request->validate(
            [
                'entry_ticket' => 'required|unique:approvals,entry_ticket',
                'serial_number' => 'required',
                'part_number' => 'required',
                'request_date' => 'required',
            ]
        );

        // check if entry ticket already exists
        $approval = Approval::where('entry_ticket', $request->input('entry_ticket'))->first();
        if ($approval) {
            return redirect()->back()->with('error', 'Entry Ticket already exists');
        }

        // find part id baaed on part number
        $part = Part::where('part_number', $request->input('part_number'))->first();
        if (!$part) {
            return redirect()->back()->with('error', 'Part Number not found');
        }

        // find service id based on serial number
        $service = Service::where('serial_number', $request->input('serial_number'))->first();
        if (!$service) {
            return redirect()->back()->with('error', 'Serial Number not found');
        }
    }
}
