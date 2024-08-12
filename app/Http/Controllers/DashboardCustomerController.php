<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Customer;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function showProfile()
    {
        // Get the authenticated user
        $user = auth()->guard('customer')->user();

        // Pass the user data to the view
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
{
    // Get the authenticated user
    $user = auth()->guard('customer')->user();

    // Validate the request
    $request->validate([
        'username' => 'max:255|unique:customers,username,' . $user->customer_id . ',customer_id',
        'current_password' => 'required',
        'new_password' => [
            'required',
            'min:8',
            'confirmed',
            'regex:/[a-z]/',      // At least one lowercase letter
            'regex:/[A-Z]/',      // At least one uppercase letter
            'regex:/[0-9]/',      // At least one digit
            'regex:/[@$!%*#?&]/', // At least one special character
        ],
    ], [
        'new_password.regex' => 'Kata sandi harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
        'new_password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
        'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        'new_password.required' => 'Kata sandi baru wajib diisi.',
        'current_password.required' => 'Kata sandi saat ini wajib diisi.',
        'username.unique' => 'Nama pengguna sudah digunakan.',
        'username.max' => 'Nama pengguna tidak boleh melebihi 255 karakter.',
    ]);

    // Check if the current password is correct
    try {
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini salah.');
        }

        // Update the user password
        Customer::where('customer_id', $user->customer_id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Update the user profile
        Customer::where('customer_id', $user->customer_id)->update([
            'username' => $request->username,
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kata sandi.');
    }
}

}
