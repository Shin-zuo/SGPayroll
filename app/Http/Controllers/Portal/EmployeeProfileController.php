<?php

namespace SGpayroll\Http\Controllers\Portal;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use SGpayroll\Employee;

class EmployeeProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $employee = Employee::find($user->employee_id);
        
        return view('portal.profile', compact('user', 'employee'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Update basic employee information that employees are allowed to change
        if ($user->employee_id) {
            $employee = Employee::find($user->employee_id);
            if ($employee) {
                $dataToUpdate = [
                    'address' => $request->address,
                    'contactNo' => $request->contactNo,
                    'contactName' => $request->contactName,
                ];

                if ($request->hasFile('profile_picture')) {
                    $request->validate([
                        'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);
                    
                    $imageName = time().'.'.$request->profile_picture->extension();  
                    $request->profile_picture->move(public_path('images/profiles'), $imageName);
                    
                    // Save to user model
                    $user->update(['profile_picture' => $imageName]);
                }

                $employee->update($dataToUpdate);
            }
        }

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
