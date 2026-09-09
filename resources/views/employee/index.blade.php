@extends('layouts.app')
@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Employee Directory</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Manage employee accounts, groups, status, and records.</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="#" class="hover:text-slate-700 transition-colors">Home</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Employees</li>
        </ol>
    </nav>
</div>

<!-- Stat Cards (Top Row) -->
@php
    $totalEmp = count($employee);
    $activeEmp = collect($employee)->where('status', '!=', 'Inactive')->count();
@endphp
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Employees -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Employees</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalEmp }}</p>
        </div>
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <i class="fa fa-users text-lg"></i>
        </div>
    </div>

    <!-- Active Employees -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Active Employees</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ $activeEmp }}</p>
        </div>
        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <i class="fa fa-user-check text-lg"></i>
        </div>
    </div>

    <!-- Inactive Employees -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Inactive Employees</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalEmp - $activeEmp }}</p>
        </div>
        <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <i class="fa fa-user-slash text-lg"></i>
        </div>
    </div>

    <!-- Groups Count -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Groups</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ count($department) }}</p>
        </div>
        <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <i class="fa fa-sitemap text-lg"></i>
        </div>
    </div>
</div>

<!-- Data Table Section -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fas fa-users"></i>
                </span>
                Active Employee Directory
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Filter, search, or add employee records and statutory configurations.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 text-slate-700 text-xs font-semibold">
                {{ $activeEmp }} active employees
            </span>
            <button type="button" id="btn-import-employee-csv"
                class="btn btn-secondary text-xs font-medium flex items-center gap-2">
                <i class="fa fa-file-csv text-emerald-600"></i> Import CSV
            </button>
            <button type="button" class="btn btn-primary text-xs font-medium flex items-center gap-2" data-toggle="modal" data-target="#addEmployee" title="Add Employee">
                <i class="fa fa-plus text-xs"></i> Add Employee
            </button>
        </div>
    </div>
    
    <div class="p-5 overflow-x-auto">
        <table id="emptable" class="w-full text-left border-collapse" style="font-size: 12px;">
            <thead>
                <tr class="bg-slate-100/75 font-semibold text-slate-600 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-2.5 px-3" style="width: 55px;">Ref #</th>
                    <th class="py-2.5 px-3">Full Name</th>
                    <th class="py-2.5 px-3">Group</th>
                    <th class="py-2.5 px-3">Position</th>
                    <th class="py-2.5 px-3 text-center">Status</th>
                    <th class="py-2.5 px-3 text-center" style="width: 108px;">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($employee as $employees)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="py-2.5 px-3 font-mono text-slate-500" style="font-size: 11px;">#{{ $employees->id }}</td>
                    <td class="py-2.5 px-3">
                        <div class="font-semibold text-slate-800" style="font-size: 12px;">{{ strtoupper($employees->full_name) }}</div>
                        <div class="text-slate-400 font-mono" style="font-size: 10px;">{{ $employees->employee_id }}</div>
                    </td>
                    <td class="py-2.5 px-3 text-slate-700 font-medium" style="font-size: 11px;">{{ strtoupper($employees->department) }}</td>
                    <td class="py-2.5 px-3 text-slate-500" style="font-size: 11px;">{{ $employees->position ?: '—' }}</td>
                    <td class="py-2.5 px-3 text-center">
                        @if($employees->status == 'Inactive')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                        @endif
                    </td>
                    <td class="py-2.5 px-3 text-center">
                        <div class="admin-action-btn-group">
                            <a href="/employee/account/{{$employees->id}}" class="admin-btn-action admin-btn-action-edit" target="_blank" title="View & Edit Account">
                                <i class="fa fa-user-edit"></i>
                            </a>
                            <a href="/employee/account/{{$employees->id}}/loans" class="admin-btn-action admin-btn-action-view" target="_blank" title="Manage Loans">
                                <i class="fa fa-receipt"></i>
                            </a>
                            <button type="button" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="admin-btn-action admin-btn-action-danger" title="Set Inactive">
                                <i class="fa fa-user-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Deactivate Confirmation Modal (Minimalist) -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body p-6">
                <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3 border border-rose-100 text-lg">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <h4 class="text-base font-bold text-slate-900 mb-1" id="deactivateModalLabel">Deactivate Employee</h4>
                <p class="text-xs text-slate-500 max-w-xs mx-auto mb-2 leading-relaxed">Are you sure you want to mark this employee as inactive? They will be moved to the inactive directory.</p>
                <form id="deactivateForm">
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer justify-center bg-slate-50 border-t border-slate-100 p-4 gap-2.5">
                <button type="button" class="btn btn-secondary flex-1" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger flex-1" id="btnYes">Deactivate</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal (Modern Minimalist 2-Column Grid) -->
<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="admin-modal-hero">
                <div>
                    <h4 class="modal-title" id="addEmployeeLabel">Add New Employee</h4>
                    <p class="modal-subtitle">Fill in personal credentials and statutory registration details.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmTasks" name="frmTasks" novalidate="">
                <div class="modal-body space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Personal & Employment Information -->
                        <div class="space-y-4">
                            <div class="border-b border-slate-100 pb-2">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                                    <i class="fa fa-id-card text-blue-600"></i> General Information
                                </h5>
                            </div>

                            <div class="form-group">
                                <label for="employee_id">Employee ID <span class="text-rose-500">*</span></label>
                                <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="e.g. EMP-001" required>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-rose-500">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-rose-500">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="mid_name">Middle Name</label>
                                    <input type="text" class="form-control" id="mid_name" name="mid_name" placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender <span class="text-rose-500">*</span></label>
                                    <select id="gender" class="form-control" name="gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="status">Civil Status</label>
                                    <select id="status" class="form-control" name="status">
                                        <option value="" selected>Select Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="birth_date">Date of Birth <span class="text-rose-500">*</span></label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date_hired">Date Hired <span class="text-rose-500">*</span></label>
                                <input type="date" class="form-control" id="date_hired" name="date_hired" required>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="department">Group <span class="text-rose-500">*</span></label>
                                    <select id="department" class="form-control" name="department" required>
                                        <option value="" selected disabled>Select Group</option>
                                        @foreach($department as $departments)
                                        <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sub_department">SubGroup <span class="text-rose-500">*</span></label>
                                    <select id="sub_department" class="form-control" name="sub_department" required>
                                        <option value="" selected disabled>Select SubGroup</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Residential Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Complete Street Address">
                            </div>

                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="09XX-XXX-XXXX">
                            </div>
                        </div>

                        <!-- Right Column: Statutory & Account Info -->
                        <div class="space-y-4">
                            <div class="border-b border-slate-100 pb-2">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                                    <i class="fa fa-shield-alt text-emerald-600"></i> Statutory &amp; Portal Account
                                </h5>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="sss_no">SSS Number</label>
                                    <input type="text" class="form-control" id="sss_no" name="sss_no" placeholder="00-0000000-0">
                                </div>
                                <div class="form-group">
                                    <label for="phil_health">PhilHealth Number</label>
                                    <input type="text" class="form-control" id="phil_health" name="phil_health" placeholder="00-000000000-0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-group">
                                    <label for="tin">TIN Number</label>
                                    <input type="text" class="form-control" id="tin" name="tin" placeholder="000-000-000">
                                </div>
                                <div class="form-group">
                                    <label for="hdmf">Pag-IBIG (HDMF)</label>
                                    <input type="text" class="form-control" id="hdmf" name="hdmf" placeholder="0000-0000-0000">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ucpb">UB Account No.</label>
                                <input type="text" class="form-control" id="ucpb" name="ucpb" placeholder="UB Account Number">
                            </div>

                            <div class="form-group">
                                <label for="emp_email">Login Email Address</label>
                                <input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="employee@company.com">
                                <p class="text-[11px] text-slate-400 mt-1">Default employee portal password: <code class="text-slate-600 font-mono bg-slate-100 px-1 py-0.5 rounded">testPass</code></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-secondary" id="btn-danger">Clear Fields</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit">
                        <i class="fa fa-check mr-1.5"></i> Save Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CSV Import Modal (Task 5) -->
<div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="admin-modal-hero">
                <div>
                    <h4 class="modal-title" id="importCsvModalLabel">Import Employees from CSV</h4>
                    <p class="modal-subtitle">Bulk onboarding via spreadsheet</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Step 1: Format Guide -->
                <div id="import-step-1">
                    <div class="p-3.5 bg-blue-50/70 border border-blue-200/80 rounded-xl mb-4 text-xs text-blue-900 leading-relaxed">
                        <i class="fa fa-info-circle text-blue-600 mr-1.5"></i>
                        Please format your CSV file exactly as shown below. Headers must match precisely. Providing an email will automatically create a portal user account with the password <strong>"testPass"</strong>.
                    </div>
                    
                    <div class="max-h-64 overflow-y-auto rounded-xl border border-slate-200 mb-5">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-[11px] font-semibold text-slate-500 uppercase tracking-wider sticky top-0">
                                    <th class="px-3.5 py-2.5 border-b border-slate-200">Column Name</th>
                                    <th class="px-3.5 py-2.5 border-b border-slate-200">Required</th>
                                    <th class="px-3.5 py-2.5 border-b border-slate-200">Example / Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">employee_id</td><td>No</td><td class="text-slate-500">EMP-001 (Unique Code)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">last_name</td><td><span class="text-rose-600 font-semibold">Yes</span></td><td class="text-slate-500">Smith</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">first_name</td><td><span class="text-rose-600 font-semibold">Yes</span></td><td class="text-slate-500">John</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">middle_name</td><td>No</td><td class="text-slate-500">Doe</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">gender</td><td>No</td><td class="text-slate-500">Male / Female</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">status</td><td>No</td><td class="text-slate-500">Single / Married</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">date_hired</td><td>No</td><td class="text-slate-500">YYYY-MM-DD (e.g. 2026-07-03)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">birth_date</td><td>No</td><td class="text-slate-500">YYYY-MM-DD</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">department</td><td>No</td><td class="text-slate-500">Department / Group Name</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">position</td><td>No</td><td class="text-slate-500">Position / Job Title</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">address</td><td>No</td><td class="text-slate-500">Street Address</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">email</td><td>No</td><td class="text-slate-500">john@example.com (Creates user account)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">sss_number</td><td>No</td><td class="text-slate-500">Numbers only</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">tin_number</td><td>No</td><td class="text-slate-500">Numbers only</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">hdmf_number</td><td>No</td><td class="text-slate-500">Numbers only (Pag-IBIG)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">philhealth_number</td><td>No</td><td class="text-slate-500">Numbers only</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">ucpb_number / ub_number</td><td>No</td><td class="text-slate-500">UB Account Number (Numbers only)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">basic_pay</td><td>No</td><td class="text-slate-500">Decimal/Float (e.g. 25000)</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">cola</td><td>No</td><td class="text-slate-500">Decimal/Float</td></tr>
                                <tr class="hover:bg-slate-50/50"><td class="px-3.5 py-2 font-mono font-medium text-slate-700">other_nt_pay</td><td>No</td><td class="text-slate-500">Decimal/Float</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="button" id="btn-proceed-upload" class="btn btn-primary">
                            Proceed to Upload <i class="fa fa-arrow-right ml-1.5 text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Upload Input -->
                <div id="import-step-2" style="display: none;">
                    <form id="employeeImportForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group mb-5">
                            <label for="import_file">Select CSV File</label>
                            <input type="file" id="import_file" name="import_file" class="form-control" accept=".csv,text/csv,text/plain" required>
                            <p class="text-xs text-slate-400 mt-1">Accepted format: .csv up to 10MB</p>
                        </div>
                        <div id="import-results" style="display:none;" class="alert mb-4"></div>
                        <div class="flex items-center justify-end gap-2.5 pt-2">
                            <button type="button" id="btn-back-step-1" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-1.5 text-xs"></i> Back to Guide
                            </button>
                            <button type="submit" id="btn-submit-import" class="btn btn-success">
                                <i class="fa fa-upload mr-1.5 text-xs"></i> Import Now
                            </button>
                        </div>
                    </form>
                </div>
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

        $('#btn-danger').on('click', function() {
            $('#frmTasks')[0].reset();
        });

        $('#btn-import-employee-csv').on('click', function() {
            // Reset to Step 1 when modal is opened
            $('#import-step-1').show();
            $('#import-step-2').hide();
            $('#import_file').val('');
            $('#import-results').hide().empty();
            $('#importCsvModal').modal('show');
        });

        $('#btn-proceed-upload').on('click', function() {
            $('#import-step-1').hide();
            $('#import-step-2').show();
        });

        $('#btn-back-step-1').on('click', function() {
            $('#import-step-2').hide();
            $('#import-step-1').show();
        });

        $('#employeeImportForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#btn-submit-import').prop('disabled', true).text('Importing...');
            $('#import-results').hide().removeClass('alert-success alert-danger alert-warning').empty();

            $.ajax({
                url: '/employee/batch-import',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json' // Forces Laravel to send JSON validation errors instead of redirects
                },
                success: function(response) {
                    $('#btn-submit-import').prop('disabled', false).text('Import Now');
                    
                    var alertClass = 'alert-success';
                    var html = '<strong>' + response.message + '</strong>';

                    if (response.failed && response.failed.length > 0) {
                        alertClass = 'alert-warning';
                        html += '<hr><p class="mb-1 font-bold">Failed rows:</p><ul class="pl-4 mb-0 text-xs">';
                        response.failed.forEach(function(item) {
                            html += '<li>Row ' + item.row + ': ' + item.reason + '</li>';
                        });
                        html += '</ul>';
                    }

                    $('#import-results').addClass(alertClass).html(html).show();
                    
                    // Reload table if anything succeeded
                    if (response.success > 0) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    $('#btn-submit-import').prop('disabled', false).text('Import Now');
                    var errorMsg = 'An error occurred during import.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#import-results').addClass('alert-danger').html('<strong>' + errorMsg + '</strong>').show();
                }
            });
        });
    });
</script>
@endsection
