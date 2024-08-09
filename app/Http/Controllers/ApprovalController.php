<?php

namespace App\Http\Controllers;

use App\Models\Approval;
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
}
