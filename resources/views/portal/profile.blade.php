@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            <i class="fa fa-user-circle text-slate-400"></i> Account Settings
        </h2>
    </div>

    @if(session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 border border-green-200 flex items-start gap-3 relative text-sm">
            <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
            <div class="text-green-700 flex-1">{{ session()->get('success') }}</div>
            <button type="button" class="text-green-500 hover:text-green-700 absolute right-3 top-3" onclick="this.parentElement.style.display='none'">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 border border-red-200 flex items-start gap-3 relative text-sm">
            <i class="fa fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div class="text-red-700 flex-1">
                <ul class="list-none p-0 m-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="text-red-500 hover:text-red-700 absolute right-3 top-3" onclick="this.parentElement.style.display='none'">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Left Column: Avatar & Basic Info -->
        <div class="col-span-1">
            <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-5 text-center">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-2 border-slate-50 shadow-sm">
                    @if($user->profile_picture)
                        <img src="{{ asset('images/profiles/' . $user->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                    @elseif($employee && $employee->profile_picture)
                        <img src="{{ asset('images/profiles/' . $employee->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold">
                            {{ strtoupper(substr($employee ? $employee->first_name : $user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $employee ? $employee->full_name : $user->name }}</h3>
                <p class="text-slate-500 text-xs mb-1 flex items-center justify-center gap-1.5">
                    <i class="fa fa-envelope text-slate-400"></i> {{ $user->email }}
                </p>
                <p class="text-slate-500 text-xs mb-4 flex items-center justify-center gap-1.5">
                    <i class="fa fa-building text-slate-400"></i> {{ $employee ? $employee->department : '-' }}
                </p>
                
                <hr class="border-slate-100 my-4">
                
                <a href="/portal" class="block w-full text-center text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50 py-2 border border-slate-200 rounded-md transition-colors">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="col-span-1 md:col-span-3">
            <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
                <div class="bg-slate-50/80 border-b border-slate-100 px-5 py-3 flex items-center">
                    <h4 class="text-sm font-semibold text-slate-800 m-0 uppercase tracking-wide">Update Profile</h4>
                </div>
                <div class="p-5">
                    <form action="/portal/profile" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <h5 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                            <i class="fa fa-camera text-slate-400"></i> Profile Picture
                        </h5>
                        <div class="mb-5">
                            <input type="file" name="profile_picture" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-md">
                            <p class="text-xs text-slate-500 mt-1.5">Allowed formats: JPG, PNG, GIF (Max 2MB)</p>
                        </div>
                        
                        <hr class="border-slate-100 my-5">

                        <h5 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                            <i class="fa fa-address-card text-slate-400"></i> Contact Information
                        </h5>
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Home Address</label>
                            <input type="text" name="address" class="w-full border border-slate-300 rounded-md p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" value="{{ $employee ? $employee->address : '' }}">
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Emergency Contact Name</label>
                                <input type="text" name="contactName" class="w-full border border-slate-300 rounded-md p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" value="{{ $employee ? $employee->contactName : '' }}">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Emergency Contact Number</label>
                                <input type="text" name="contactNo" class="w-full border border-slate-300 rounded-md p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" value="{{ $employee ? $employee->contactNo : '' }}">
                            </div>
                        </div>
                        
                        <hr class="border-slate-100 my-5">
                        
                        <h5 class="text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-2">
                            <i class="fa fa-lock text-slate-400"></i> Security Options
                        </h5>
                        <p class="text-xs text-slate-500 mb-4">Leave blank if you don't want to change your password.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">New Password</label>
                                <input type="password" name="password" class="w-full border border-slate-300 rounded-md p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="w-full border border-slate-300 rounded-md p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-5 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
