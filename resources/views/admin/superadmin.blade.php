@extends('layouts.app')
@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Super Admin Dashboard</h1>
    <span class="text-sm font-medium text-slate-500">Leave Credit Window Management</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Window Status Card -->
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Leave Window Status</h3>
        @if($isAutoOpen)
            <div class="flex items-center gap-2 mb-3">
                <span class="h-3.5 w-3.5 rounded-full bg-green-500 inline-block animate-pulse"></span>
                <span class="text-base font-semibold text-green-700">Open (Auto-December)</span>
            </div>
            <p class="text-xs text-slate-500">Currently within the standard annual Dec 14–31 window.</p>
        @elseif($isManualOpen)
            <div class="flex items-center gap-2 mb-3">
                <span class="h-3.5 w-3.5 rounded-full bg-amber-500 inline-block animate-pulse"></span>
                <span class="text-base font-semibold text-amber-700">Open (Manual Override)</span>
            </div>
            <p class="text-xs text-slate-500">Manually opened by user ID #{{ $setting->opened_by }} on {{ $setting->opened_at->format('M d, Y h:ia') }}.</p>
        @else
            <div class="flex items-center gap-2 mb-3">
                <span class="h-3.5 w-3.5 rounded-full bg-red-500 inline-block"></span>
                <span class="text-base font-semibold text-red-700">Closed</span>
            </div>
            <p class="text-xs text-slate-500">Leave credit editing is currently locked for all admins.</p>
        @endif
    </div>

    <!-- Toggle Controls Card -->
    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm col-span-2">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Manual Override Toggle</h3>
        <div class="flex items-center gap-4">
            @if($isManualOpen)
                <form action="{{ route('superadmin.leave-window.close') }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors shadow-sm">
                        <i class="fas fa-lock mr-2"></i> Close Leave Window Manually
                    </button>
                </form>
            @else
                <form action="{{ route('superadmin.leave-window.open') }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors shadow-sm" @if($isAutoOpen) disabled title="Auto-open is already active" @endif>
                        <i class="fas fa-unlock mr-2"></i> Open Leave Window Manually
                    </button>
                </form>
            @endif
            <p class="text-xs text-slate-500 max-w-sm">Use this manual switch to allow admins to edit, update, or assign leave credits outside the December 14–31 date window for emergency corrections.</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-6">
        {{ session('success') }}
    </div>
@endif

<!-- Employee Locks Table -->
<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-base font-semibold text-slate-800">Employee Leave Locks (Year: {{ $currentYear }})</h2>
            <p class="text-xs text-slate-500">Manage individual lock bypasses. Resetting a lock allows the admin to edit this employee's leave credits again once.</p>
        </div>
    </div>

    <div class="overflow-x-auto p-4">
        <table id="locksTable" class="table table-bordered table-striped w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-100 font-medium text-slate-600 uppercase text-xs">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>VL Locked</th>
                    <th>SL Locked</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->id }}</td>
                    <td class="font-semibold">{{ strtoupper($emp->full_name) }}</td>
                    <td>{{ strtoupper($emp->department) }}</td>
                    <td>
                        @if($emp->vacation_locked)
                            <span class="label label-danger">Locked</span>
                        @else
                            <span class="label label-success">Unlocked / Empty</span>
                        @endif
                    </td>
                    <td>
                        @if($emp->sick_locked)
                            <span class="label label-danger">Locked</span>
                        @else
                            <span class="label label-success">Unlocked / Empty</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($emp->leave_set)
                            <form action="{{ route('superadmin.leave-window.reset-lock') }}" method="POST" class="inline">
                                {{ csrf_field() }}
                                <input type="hidden" name="employee_id" value="{{ $emp->id }}">
                                <input type="hidden" name="year" value="{{ $currentYear }}">
                                <button type="submit" class="btn btn-xs btn-warning" onclick="return confirm('Bypass once-per-year lock for {{ $emp->full_name }}?')">
                                    <i class="fas fa-history"></i> Reset Lock
                                </button>
                            </form>
                        @else
                            <button class="btn btn-xs btn-default" disabled>No Locked Records</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#locksTable').DataTable();
        }
    });
</script>
