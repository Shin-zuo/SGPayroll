<?php

namespace SGpayroll\Http\Controllers\Admin;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        return view('admin.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images/profiles'), $imageName);

            $user->update(['profile_picture' => $imageName]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
