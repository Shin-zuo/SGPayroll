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

        <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-slate-700 block">Annual Leave Reload (11 Credits: 6 VL / 5 SL)</span>
                <span class="text-xs text-slate-500">Resets all active employees to 6 Vacation & 5 Sick leaves. Automatically runs every 2nd week of December (Dec 14+).</span>
            </div>
            <form action="{{ route('superadmin.leave-window.reload-credits') }}" method="POST" onsubmit="return confirm('Reload annual leave credits to 11 (6 VL, 5 SL) for all active employees?');">
                {{ csrf_field() }}
                <input type="hidden" name="year" value="{{ $currentYear }}">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-sm text-xs flex items-center gap-1.5 shrink-0">
                    <i class="fas fa-sync-alt"></i> Run Annual Leave Reload
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-6">
        {{ session('success') }}
    </div>
@endif

<!-- Employee Locks Table -->
<div class="admin-table-card mb-8">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-lock"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Employee Leave Locks</h2>
                    <span class="admin-table-badge">{{ count($employees) }} employees</span>
                </div>
                <p class="text-xs text-slate-400">Manage individual lock bypasses for leave credit editing (Year: {{ $currentYear }})</p>
            </div>
        </div>
    </div>

    <div class="p-4">
        <table id="locksTable" class="admin-table w-full text-left">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
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
                    <td class="font-mono text-xs text-slate-500">#{{ $emp->id }}</td>
                    <td class="font-semibold text-slate-800">{{ strtoupper($emp->full_name) }}</td>
                    <td class="text-slate-600">{{ strtoupper($emp->department) }}</td>
                    <td>
                        @if($emp->vacation_locked)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                <span>Locked</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Unlocked</span>
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($emp->sick_locked)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                <span>Locked</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Unlocked</span>
                            </span>
                        @endif
                    </td>
                    <td class="admin-table-actions whitespace-nowrap text-right">
                        @if($emp->leave_set)
                            <form action="{{ route('superadmin.leave-window.reset-lock') }}" method="POST" class="inline">
                                {{ csrf_field() }}
                                <input type="hidden" name="employee_id" value="{{ $emp->id }}">
                                <input type="hidden" name="year" value="{{ $currentYear }}">
                                <button type="submit" class="admin-btn-action admin-btn-action-view" onclick="return confirm('Bypass once-per-year lock for {{ $emp->full_name }}?')">
                                    <i class="fa fa-history"></i>
                                    <span>Reset Lock</span>
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-slate-400 italic">No Locked Records</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#locksTable').DataTable();
        }
    });
</script>
@endsection
