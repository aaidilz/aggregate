<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardCustomerController extends Controller
{
    public function index()
{
    // Get the authenticated user
    $user = auth()->guard('customer')->user();
    $countPart = Part::count();
    $countService = Service::count();
    // find the approval data based on the customer_id
    $approvals = Approval::where('customer_id', $user->customer_id)->get();

    // Count the approval data
    $countApproval = $approvals->count();

    // Pass the count to the view
    return view('customer.dashboard', compact('countApproval', 'countPart', 'countService'));
}

}
