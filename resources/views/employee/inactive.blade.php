@extends('layouts.app')
@section('content')
<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Inactive Employees</h1>
        <p class="text-sm text-slate-500 mt-0.5">Manage deactivated staff accounts, review historical employment dates, and restore active status.</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-700 transition-colors">Employees</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Inactive</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 dark:bg-slate-900/60 px-4 sm:px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 flex items-center justify-center text-sm shadow-xs">
                    <i class="fas fa-user-slash"></i>
                </span>
                Inactive Employee Directory
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Archived records. Click the check button to restore an employee account to active status.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-transparent dark:border-slate-700/60 text-xs font-semibold">
                {{ count($inactive_employee) }} inactive records
            </span>
            <a href="{{ route('employee') }}" class="btn btn-secondary text-xs font-medium flex items-center gap-2">
                <i class="fa fa-arrow-left text-xs"></i> Back to Active
            </a>
        </div>
    </div>

    <div class="p-3.5 sm:p-5 overflow-x-auto">
        <table id="emptable" class="w-full text-left border-collapse" style="font-size: 12px;">
            <thead>
                <tr class="bg-slate-100/75 dark:bg-slate-800/80 font-semibold text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <th class="py-2.5 px-3" style="width: 55px;">Ref #</th>
                    <th class="py-2.5 px-3">Full Name</th>
                    <th class="py-2.5 px-3">Department</th>
                    <th class="py-2.5 px-3">Position</th>
                    <th class="py-2.5 px-3">Date Hired</th>
                    <th class="py-2.5 px-3 text-center">Status</th>
                    <th class="py-2.5 px-3 text-center" style="width: 90px;">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($inactive_employee as $employees)
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="py-2.5 px-3 font-mono text-slate-500 dark:text-slate-300" style="font-size: 11px;">#{{$employees->id}}</td>
                    <td class="py-2.5 px-3">
                        <div class="font-semibold text-slate-800 dark:text-white" style="font-size: 12px;">{{ strtoupper($employees->full_name) }}</div>
                        <div class="text-slate-400 dark:text-slate-300 font-mono" style="font-size: 10px;">{{ $employees->employee_id }}</div>
                    </td>
                    <td class="py-2.5 px-3 text-slate-700 dark:text-slate-100 font-medium" style="font-size: 11px;">{{ strtoupper($employees->department) }}</td>
                    <td class="py-2.5 px-3 text-slate-500 dark:text-slate-300" style="font-size: 11px;">{{ $employees->position ?: '—' }}</td>
                    <td class="py-2.5 px-3 text-slate-600 dark:text-slate-200" style="font-size: 11px;">{{ $employees->date_hired ?: '—' }}</td>
                    <td class="py-2.5 px-3 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60">Inactive</span>
                    </td>
                    <td class="py-2.5 px-3 text-center">
                        <div class="admin-action-btn-group">
                            <a href="/employee/account/{{$employees->id}}" class="admin-btn-action admin-btn-action-edit" target="_blank" title="View Account">
                                <i class="fa fa-user-edit"></i>
                            </a>
                            <button type="button" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="admin-btn-action admin-btn-action-success" title="Restore to Active">
                                <i class="fa fa-user-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Activate Account Modal (Minimalist) -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body p-6">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 border border-emerald-100 text-lg">
                    <i class="fa fa-user-check"></i>
                </div>
                <h4 class="text-base font-bold text-slate-900 mb-1" id="activateModalLabel">Activate Employee</h4>
                <p class="text-xs text-slate-500 max-w-xs mx-auto mb-2 leading-relaxed">Restore this employee to active status? They will reappear in the active employee directory and current payroll batches.</p>
                <form id="activateForm">
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer justify-center bg-slate-50 border-t border-slate-100 p-4 gap-2.5">
                <button type="button" class="btn btn-secondary flex-1" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success flex-1" id="btnYesActive">Activate</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/employee/employee.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#emptable').DataTable();
    });
</script>
@endsection
