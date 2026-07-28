<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PlumberController extends Controller
{
    private function checkStaff()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            abort(403, 'Unauthorized action. Staff login required.');
        }
        return $staff;
    }

    private function checkAdmin()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff || !$staff->isAdmin()) {
            abort(403, 'Unauthorized action. Only Admin can add a plumber.');
        }
        return $staff;
    }

    public function index(Request $request)
    {
        $staff = $this->checkStaff();

        $query = Staff::where('staffID', '!=', $staff->staffID);

        // Filter by Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('staffName', 'like', "%{$search}%")
                  ->orWhere('staffEmail', 'like', "%{$search}%")
                  ->orWhere('staffPhoneNo', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $plumbers = $query->get();

        // Calculate dynamic completed jobs for each plumber
        foreach ($plumbers as $plumber) {
            $plumber->jobs_completed = Booking::where('staffID', $plumber->staffID)->where('bookingStatus', 'completed')->count();
        }

        return view('staff.plumbers', compact('staff', 'plumbers'));
    }

    private function formatMalaysianPhoneNumber($phone)
    {
        // Remove all non-numeric characters except +
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);
        
        // Normalize to +60 format
        if (strpos($cleaned, '+60') === 0) {
            $number = substr($cleaned, 3);
        } elseif (strpos($cleaned, '60') === 0) {
            $number = substr($cleaned, 2);
        } elseif (strpos($cleaned, '0') === 0) {
            $number = substr($cleaned, 1);
        } else {
            $number = $cleaned;
        }
        
        $prefix = '+60';
        
        if (strpos($number, '11') === 0) {
            // format: +60 11-XXXX XXXX
            $part1 = substr($number, 0, 2);
            $part2 = substr($number, 2, 4);
            $part3 = substr($number, 6);
            return "{$prefix} {$part1}-{$part2} {$part3}";
        } elseif (preg_match('/^1[0-9]/', $number)) {
            // format: +60 1X-XXX XXXX
            $part1 = substr($number, 0, 2);
            $part2 = substr($number, 2, 3);
            $part3 = substr($number, 5);
            return "{$prefix} {$part1}-{$part2} {$part3}";
        } elseif (strpos($number, '3') === 0) {
            // format: +60 3-XXXX XXXX
            $part1 = substr($number, 0, 1);
            $part2 = substr($number, 1, 4);
            $part3 = substr($number, 5);
            return "{$prefix} {$part1}-{$part2} {$part3}";
        } elseif (preg_match('/^[4-9]/', $number)) {
            // format: +60 X-XXX XXXX
            $part1 = substr($number, 0, 1);
            $part2 = substr($number, 1, 3);
            $part3 = substr($number, 4);
            return "{$prefix} {$part1}-{$part2} {$part3}";
        }
        
        return $phone;
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        if ($request->filled('staffPhoneNo')) {
            $normalizedPhone = preg_replace('/[^0-9+]/', '', $request->staffPhoneNo);
            $request->merge(['staffPhoneNo' => $normalizedPhone]);
        }

        $request->validate([
            'staffName'      => ['required', 'string', 'max:255'],
            'staffEmail'     => ['required', 'string', 'email', 'max:255', 'unique:staffs,staffEmail'],
            'staffPhoneNo'   => ['required', 'string', 'regex:/^(?:\+?6?0)[0-9]{8,10}$/', 'unique:staffs,staffPhoneNo'],
            'status'         => ['required', 'string', 'in:active,inactive'],
            'staffPassword'  => ['required', 'string', 'min:6'],
            'avatar'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], [
            'staffPhoneNo.regex' => 'The phone number format must be a valid Malaysian number (e.g., 012-3456789 or +6011-12345678).',
            'staffPhoneNo.unique' => 'The phone number has already been taken.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $fileName);
            $avatarPath = 'uploads/avatars/' . $fileName;
        }

        Staff::create([
            'staffName'      => $request->staffName,
            'staffEmail'     => $request->staffEmail,
            'staffPhoneNo'   => $this->formatMalaysianPhoneNumber($request->staffPhoneNo),
            'specialization' => null,
            'status'         => $request->status,
            'avatar'         => $avatarPath,
            'staffPassword'  => Hash::make($request->staffPassword),
            'adminID'        => Auth::guard('staff')->id(),
        ]);

        return redirect()->route('staff.plumbers')->with('success', 'Plumber added successfully!');
    }

    public function update(Request $request, $id)
    {
        $this->checkStaff();

        $plumber = Staff::where('staffID', $id)->where('staffID', '!=', Auth::guard('staff')->id())->firstOrFail();
        
        if ($request->filled('staffPhoneNo')) {
            $normalizedPhone = preg_replace('/[^0-9+]/', '', $request->staffPhoneNo);
            $request->merge(['staffPhoneNo' => $normalizedPhone]);
        }

        $request->validate([
            'staffName'     => ['required', 'string', 'max:255'],
            'staffEmail'    => ['required', 'string', 'email', 'max:255', 'unique:staffs,staffEmail,' . $plumber->staffID . ',staffID'],
            'staffPhoneNo'  => ['required', 'string', 'regex:/^(?:\+?6?0)[0-9]{8,10}$/', 'unique:staffs,staffPhoneNo,' . $plumber->staffID . ',staffID'],
            'status'        => ['required', 'string', 'in:active,inactive'],
            'staffPassword' => ['nullable', 'string', 'min:6'],
            'avatar'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], [
            'staffPhoneNo.regex' => 'The phone number format must be a valid Malaysian number (e.g., 012-3456789 or +6011-12345678).',
            'staffPhoneNo.unique' => 'The phone number has already been taken.',
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $fileName);
            $plumber->avatar = 'uploads/avatars/' . $fileName;
        }

        $plumber->staffName = $request->staffName;
        $plumber->staffEmail = $request->staffEmail;
        $plumber->staffPhoneNo = $this->formatMalaysianPhoneNumber($request->staffPhoneNo);
        $plumber->status = $request->status;

        if ($request->filled('staffPassword')) {
            $plumber->staffPassword = Hash::make($request->staffPassword);
        }

        $plumber->save();

        return redirect()->route('staff.plumbers')->with('success', 'Plumber account updated successfully!');
    }

    public function destroy($id)
    {
        $this->checkStaff();

        $plumber = Staff::where('staffID', $id)->where('staffID', '!=', Auth::guard('staff')->id())->firstOrFail();
        $plumber->delete();

        return redirect()->route('staff.plumbers')->with('success', 'Plumber deleted successfully!');
    }
}
