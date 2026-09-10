@extends('layouts.app')
@section('content')

<!-- Select2 Stylesheet & Custom Tailwind Integration -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"/>
<style>
    /* Select2 Modern SGPayroll / Tailwind Customization */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        background-color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 10px !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.15s ease-in-out !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus {
        border-color: #3b82f6 !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 0.875rem !important;
        line-height: 40px !important;
        padding-left: 2px !important;
        padding-right: 24px !important;
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
        top: 1px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #64748b transparent transparent transparent !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #64748b transparent !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.05) !important;
        background-color: #ffffff !important;
        z-index: 9999 !important;
        overflow: hidden !important;
        margin-top: 4px !important;
    }
    .select2-search--dropdown {
        padding: 8px 10px !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        padding: 7px 10px 7px 30px !important;
        font-size: 0.875rem !important;
        background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 8px center / 16px 16px !important;
        outline: none !important;
    }
    .select2-search--dropdown .select2-search__field:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }
    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 0.875rem !important;
        color: #334155 !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .select2-results__option:last-child {
        border-bottom: none !important;
    }
    .select2-results__option--highlighted[aria-selected] {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
    }
    .select2-results__option[aria-selected="true"] {
        background-color: #dbeafe !important;
        color: #1e40af !important;
        font-weight: 600 !important;
    }
    .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: #f1f5f9 !important;
        opacity: 0.6 !important;
        cursor: not-allowed !important;
        border-color: #cbd5e1 !important;
    }
</style>

<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Payslip Management</h1>
        <p class="text-sm text-slate-500 mt-0.5">Generate batch or individual employee payslips and manage historical records.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100 shadow-sm">
            <i class="fas fa-file-invoice-dollar"></i> {{ $totalPayslips }} Generated Payslips
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 shadow-sm">
            <i class="fas fa-building"></i> {{ $department->count() }} Departments
        </span>
    </div>
</div>

<!-- Generate Payslip Form Card (Clean Full-Width) -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                <i class="fas fa-sliders-h"></i>
            </span>
            Generate Payslip Configuration
        </h2>
        <span class="text-xs text-slate-400 font-medium">Export printable PDF payslips</span>
    </div>
    
    <div class="p-6">
        <form method="POST" action="/payslip/view-payslip" class="space-y-5">
            {{ csrf_field() }}
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Department Selection -->
                <div class="{{ (isset($errors) && $errors->has('department')) ? 'has-error' : '' }}">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Department :</label>
                    <select id="department" name="department" class="w-full text-sm border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm {{ (isset($errors) && $errors->has('department')) ? 'border-red-500' : '' }}" required>
                        <option value="">--- Select Department ---</option>
                        @foreach($department as $departments)
                        <option value="{{ strtoupper($departments->department_name) }}">{{ strtoupper($departments->department_name) }} - {{ strtoupper($departments->department_code) }}</option>
                        @endforeach
                    </select>
                    @if (isset($errors) && $errors->has('department'))
                        <span class="text-xs text-red-500 mt-1 block">{{ $errors->first('department') }}</span>
                    @endif
                </div>
                
                <!-- Date Selection -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Period Month :</label>
                    <input type="month" id="date_payslip" name="date_payslip" value="{{ date('Y-m') }}" class="w-full text-sm border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
                
                <!-- Payroll Number -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Payroll No. :</label>
                    <select id="payroll_number" name="payroll_number" class="w-full text-sm border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="1">Payroll 1 (1st Half)</option>
                        <option value="2">Payroll 2 (2nd Half)</option>
                        <option value="3">Payroll 3</option>
                        <option value="4">Payroll 4</option>
                        <option value="5">Payroll 5</option>
                    </select>
                </div>
            </div>

            <!-- Scope Selection -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <div class="md:col-span-5">
                        <label class="flex items-center gap-3 p-2.5 rounded-lg border border-slate-200 bg-white hover:bg-blue-50/50 cursor-pointer transition-colors shadow-xs">
                            <input type="checkbox" id="print_all" name="print_all" value="1" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-slate-700">Print All Department Employees</span>
                                <span class="text-xs text-slate-400">Batch export payslips for everyone in group</span>
                            </div>
                        </label>
                    </div>
                    
                    <div class="md:col-span-7" id="employee_select_wrapper">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 m-0">
                                Specific Employee :
                            </label>
                            <!-- Active / Inactive Status Filter Controls -->
                            <div class="inline-flex items-center bg-slate-200/80 p-0.5 rounded-lg text-xs" id="employee_status_toggle_group" role="group" aria-label="Employee Status Filter">
                                <button type="button" class="btn-emp-status px-2.5 py-1 rounded-md font-semibold transition-all duration-150 active bg-white text-blue-700 shadow-xs border border-slate-200/60" data-status="1" title="Show Active Employees">
                                    <i class="fa fa-circle-check text-emerald-500 mr-1 text-[11px]"></i> Active
                                </button>
                                <button type="button" class="btn-emp-status px-2.5 py-1 rounded-md font-medium transition-all duration-150 text-slate-600 hover:text-slate-900" data-status="2" title="Show Inactive Employees">
                                    <i class="fa fa-circle-xmark text-rose-500 mr-1 text-[11px]"></i> Inactive
                                </button>
                                <button type="button" class="btn-emp-status px-2.5 py-1 rounded-md font-medium transition-all duration-150 text-slate-600 hover:text-slate-900" data-status="all" title="Show All Employees">
                                    <i class="fa fa-users text-slate-400 mr-1 text-[11px]"></i> All
                                </button>
                                <input type="hidden" id="employee_status_filter" name="employee_status_filter" value="1">
                            </div>
                        </div>
                        <select id="employee_id" name="employee_id" class="w-full text-sm border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white" style="width: 100%;">
                            <option value="">-- Choose employee from department --</option>
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                            <i class="fa fa-magnifying-glass text-[10px]"></i> Type employee name or ID in the dropdown to quickly search.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex items-center justify-between">
                <span class="text-xs text-slate-400">
                    <i class="fa fa-info-circle mr-1.5"></i> Generated PDF opens in a new browser tab for direct printing.
                </span>
                <button type="submit" formtarget="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors flex items-center shadow-sm text-sm cursor-pointer">
                    <i class="fa fa-print mr-1.5"></i> Generate & Print Payslips
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Created Payslips Table Section -->
<div id="created-payslips" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fas fa-table"></i>
                </span>
                Created Payroll Directory
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Sorted newest at top. Search by employee or filter by month and year.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 text-slate-700 text-xs font-semibold">
                Showing {{ $payrolls->firstItem() ?? 0 }} - {{ $payrolls->lastItem() ?? 0 }} of {{ $payrolls->total() }} records
            </span>
        </div>
    </div>

    <!-- Search & Filter Controls (Single Clean Line) -->
    <div class="p-4 bg-slate-50/70 border-b border-slate-200">
        <form method="GET" action="{{ url('/payslip') }}" style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin: 0;">
            <!-- Search Input: compact and comfortable width -->
            <div style="position: relative; width: 260px;">
                <input type="text" 
                       id="payslip_search_input"
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search employee or code..." 
                       class="form-control"
                       style="height: 38px; padding-left: 32px; padding-right: 28px; width: 100%; border-radius: 6px; font-size: 13px; background-color: #fff;">
                <i class="fa fa-search text-slate-400" style="position: absolute; left: 10px; top: 12px; font-size: 13px; pointer-events: none;"></i>
                @if(!empty(request('search')))
                <a href="{{ url('/payslip?' . http_build_query(request()->except('search'))) }}" 
                   style="position: absolute; right: 8px; top: 10px; color: #94a3b8;" 
                   title="Clear search">
                    <i class="fa fa-times-circle" style="font-size: 14px;"></i>
                </a>
                @endif
            </div>

            <!-- Month Filter -->
            <div style="width: 140px;">
                <select name="month" class="form-control" style="height: 38px; width: 100%; border-radius: 6px; font-size: 13px; background-color: #fff;">
                    <option value="all">All Months</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Year Filter -->
            <div style="width: 125px;">
                <select name="year" class="form-control" style="height: 38px; width: 100%; border-radius: 6px; font-size: 13px; background-color: #fff;">
                    <option value="all">All Years</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ (request('year') == $yr) ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Filter -->
            <div style="width: 170px;">
                <select name="dept" class="form-control" style="height: 38px; width: 100%; border-radius: 6px; font-size: 13px; background-color: #fff;">
                    <option value="all">All Departments</option>
                    @foreach($department as $deptItem)
                        <option value="{{ strtoupper($deptItem->department_name) }}" {{ request('dept') == strtoupper($deptItem->department_name) ? 'selected' : '' }}>
                            {{ strtoupper($deptItem->department_name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div style="display: inline-flex; align-items: center; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="height: 38px; padding: 0 16px; border-radius: 6px; font-size: 13px; display: inline-flex; align-items: center; cursor: pointer;">
                    <i class="fa fa-filter mr-1.5"></i> Filter
                </button>
                @if(!empty(request('search')) || (request('month') && request('month') !== 'all') || (request('year') && request('year') !== 'all') || (request('dept') && request('dept') !== 'all'))
                <a href="{{ url('/payslip') }}" class="btn btn-secondary" style="height: 38px; padding: 0 12px; border-radius: 6px; font-size: 13px; display: inline-flex; align-items: center; cursor: pointer;" title="Reset All Filters">
                    <i class="fa fa-undo mr-1.5"></i> Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Content -->
    <div>
        <table class="w-full text-left border-collapse" style="font-size: 12px;">
            <thead>
                <tr class="bg-slate-100/75 font-semibold text-slate-600 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-2.5 px-2" style="width: 48px;">Ref #</th>
                    <th class="py-2.5 px-2">Employee</th>
                    <th class="py-2.5 px-2">Dept / Payroll</th>
                    <th class="py-2.5 px-2">Period</th>
                    <th class="py-2.5 px-2 text-right">Gross</th>
                    <th class="py-2.5 px-2 text-right">Deductions</th>
                    <th class="py-2.5 px-2 text-right">Net Pay</th>
                    <th class="py-2.5 px-2">Created</th>
                    <th class="py-2.5 px-2 text-center" style="width: 108px;">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $p)
                @php
                    $emp = $p->employee;
                    $empName = $emp ? $emp->full_name : ('Employee #' . $p->employee_code);
                    $empCode = $emp ? $emp->employee_id : $p->employee_code;
                    $initials = $emp ? strtoupper(substr($emp->employee_Fname, 0, 1) . substr($emp->employee_Lname, 0, 1)) : 'EP';
                    $deductions = $p->total_deduction > 0 ? $p->total_deduction : max(0, $p->gross_pay - $p->net_pay);
                @endphp
                <tr class="hover:bg-slate-50/80 transition-colors" id="payslip-row-{{ $p->id }}">
                    <td class="py-2.5 px-2 font-mono text-slate-500" style="font-size: 11px;">
                        #{{ $p->id }}
                    </td>
                    <td class="py-2.5 px-2">
                        <div class="font-semibold text-slate-800" style="font-size: 12px;">{{ $empName }}</div>
                        <div class="text-slate-400 font-mono" style="font-size: 10px;">{{ $empCode }}</div>
                    </td>
                    <td class="py-2.5 px-2">
                        <div class="text-slate-700 font-medium" style="font-size: 11px;">{{ $p->department }}</div>
                        <div class="text-slate-400" style="font-size: 10px;">#{{ $p->payroll_number }}</div>
                    </td>
                    <td class="py-2.5 px-2" style="white-space: nowrap;">
                        <div class="text-slate-700 font-medium" style="font-size: 11px;">{{ \Carbon\Carbon::parse($p->date_from)->format('M d') }} – {{ \Carbon\Carbon::parse($p->date_to)->format('M d, Y') }}</div>
                        <div class="text-slate-400" style="font-size: 10px;">Mo. {{ $p->monthly_record }} / {{ $p->year }}</div>
                    </td>
                    <td class="py-2.5 px-2 text-right font-medium text-slate-700 col-gross-pay" style="white-space: nowrap; font-size: 12px;">
                        ₱{{ number_format((float)$p->gross_pay, 2) }}
                    </td>
                    <td class="py-2.5 px-2 text-right font-medium text-rose-600 col-total-deductions" style="white-space: nowrap; font-size: 12px;">
                        ₱{{ number_format((float)$deductions, 2) }}
                    </td>
                    <td class="py-2.5 px-2 text-right font-bold text-emerald-600 col-net-pay" style="white-space: nowrap; font-size: 13px;">
                        ₱{{ number_format((float)$p->net_pay, 2) }}
                    </td>
                    <td class="py-2.5 px-2 text-slate-500" style="font-size: 11px; white-space: nowrap;">
                        {{ $p->created_at ? $p->created_at->format('M d, Y') : '—' }}
                    </td>
                    <td class="py-2.5 px-2 text-center" style="width: 108px;">
                        <div style="display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                            <button type="button" class="btn-edit-payslip" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; color: #0284c7; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 5px; cursor: pointer;" data-id="{{ $p->id }}" title="Edit Payslip" aria-label="Edit Payslip">
                                <i class="fa fa-pen"></i>
                            </button>
                            <a href="{{ route('payslip.print-single', $p->id) }}" target="_blank" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; color: #2563eb; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 5px; text-decoration: none; cursor: pointer;" title="Print Payslip" aria-label="Print Payslip">
                                <i class="fa fa-print"></i>
                            </a>
                            <button type="button" class="btn-delete-payslip" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; color: #e11d48; background-color: #fff1f2; border: 1px solid #fecdd3; border-radius: 5px; cursor: pointer;" data-id="{{ $p->id }}" data-employee="{{ $empName }}" title="Delete Payslip" aria-label="Delete Payslip">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-12 px-4 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3 text-xl">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-600 mb-1">No payslips found</h3>
                            <p class="text-xs text-slate-400 max-w-sm mb-4">No payslip records matched your filter criteria or no payslips have been created yet.</p>
                            @if(!empty(request('search')) || (request('month') && request('month') !== 'all') || (request('year') && request('year') !== 'all') || (request('dept') && request('dept') !== 'all'))
                            <a href="{{ url('/payslip') }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-1.5 px-3 rounded-md transition-colors">
                                Clear Filters
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Leave-Style Pagination -->
    @if($payrolls->hasPages())
    <div class="admin-pagination-container">
        <div class="admin-pagination-info">
            Showing {{ $payrolls->firstItem() ?? 0 }} to {{ $payrolls->lastItem() ?? 0 }} of {{ $payrolls->total() }} records
        </div>
        <div>
            {{ $payrolls->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Edit Payslip Modal (Modern Redesign) -->
<style>
    #editPayslipModal .modal-dialog {
        max-width: 1040px;
        margin: 1.75rem auto;
    }
    #editPayslipModal .modal-content {
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        background: #ffffff;
    }
    #editPayslipModal .modal-header-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 20px 24px;
        border-bottom: none;
        position: relative;
    }
    #editPayslipModal .emp-avatar {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2);
        flex-shrink: 0;
    }
    #editPayslipModal .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 500;
        color: #94a3b8;
        background: rgba(255, 255, 255, 0.08);
        padding: 3px 10px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    #editPayslipModal .header-badge i {
        color: #38bdf8;
        font-size: 10px;
    }
    /* Sticky Live KPI Dashboard */
    #editPayslipModal .kpi-dashboard {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 24px;
        position: sticky;
        top: 0;
        z-index: 20;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    }
    #editPayslipModal .kpi-card {
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 190px;
        transition: all 0.2s ease;
    }
    #editPayslipModal .kpi-card-gross {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }
    #editPayslipModal .kpi-card-deductions {
        background: #fff1f2;
        border: 1px solid #fecdd3;
    }
    #editPayslipModal .kpi-card-net {
        background: #f0f9ff;
        border: 2px solid #38bdf8;
        box-shadow: 0 4px 6px -1px rgba(56, 189, 248, 0.15);
    }
    #editPayslipModal .kpi-icon-pill {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    #editPayslipModal .kpi-op {
        font-size: 18px;
        font-weight: 700;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Tab Switcher */
    #editPayslipModal .nav-tabs-custom {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 24px 0 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        overflow-x: auto;
    }
    #editPayslipModal .tab-btn {
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 6px 6px 0 0;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    #editPayslipModal .tab-btn:hover {
        color: #1e293b;
        background: #f1f5f9;
    }
    #editPayslipModal .tab-btn.active {
        color: #2563eb;
        background: #ffffff;
        border-bottom: 2px solid #2563eb;
        box-shadow: 0 -2px 4px rgba(0,0,0,0.02);
    }
    #editPayslipModal .tab-subtotal-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 9999px;
        background: #e2e8f0;
        color: #475569;
    }
    #editPayslipModal .tab-btn.active .tab-subtotal-badge {
        background: #dbeafe;
        color: #1d4ed8;
    }
    /* Section Cards */
    #editPayslipModal .section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 18px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        margin-bottom: 16px;
    }
    #editPayslipModal .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }
    #editPayslipModal .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        margin: 0;
    }
    #editPayslipModal .section-title-icon {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    /* Input Groups */
    #editPayslipModal .field-group {
        margin-bottom: 11px;
    }
    #editPayslipModal .field-label {
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #editPayslipModal .field-label span.sub-text {
        font-size: 10px;
        font-weight: 400;
        color: #94a3b8;
    }
    #editPayslipModal .input-currency-wrapper {
        display: flex;
        align-items: stretch;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #ffffff;
        transition: all 0.15s ease;
        overflow: hidden;
    }
    #editPayslipModal .input-currency-wrapper:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    #editPayslipModal .currency-prefix {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        border-right: 1px solid #e2e8f0;
        user-select: none;
    }
    #editPayslipModal .qty-suffix {
        background: #f8fafc;
        color: #64748b;
        font-weight: 500;
        font-size: 10px;
        padding: 0 8px;
        display: flex;
        align-items: center;
        border-left: 1px solid #e2e8f0;
        text-transform: uppercase;
        user-select: none;
    }
    #editPayslipModal .custom-input {
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        padding: 6px 10px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        width: 100% !important;
        background: transparent !important;
        height: auto !important;
    }
    #editPayslipModal .custom-input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }
</style>

<div class="modal fade" id="editPayslipModal" tabindex="-1" role="dialog" aria-labelledby="editPayslipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modern Header with Identity Card -->
            <div class="modal-header-hero">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="emp-avatar" id="edit_emp_avatar">
                            <span id="edit_emp_initials">EP</span>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <h5 class="modal-title" id="editPayslipModalLabel" style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0;">
                                    <span id="edit_emp_name">Employee Name</span>
                                </h5>
                                <span class="badge" style="background: rgba(56, 189, 248, 0.2); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 11px; padding: 2px 8px; border-radius: 9999px; font-weight: 600;">
                                    Payslip #<span id="edit_payslip_id"></span>
                                </span>
                            </div>
                            <!-- Rich Meta Badges -->
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 6px;">
                                <span class="header-badge">
                                    <i class="fa fa-id-badge"></i> <span id="edit_emp_code">—</span>
                                </span>
                                <span class="header-badge">
                                    <i class="fa fa-building"></i> <span id="edit_emp_dept">—</span>
                                </span>
                                <span class="header-badge">
                                    <i class="fa fa-calendar-alt"></i> <span id="edit_payroll_period">—</span>
                                </span>
                                <span class="header-badge">
                                    <i class="fa fa-layer-group"></i> <span id="edit_payroll_number">—</span>
                                </span>
                            </div>
                            <!-- Hidden for backwards-compatibility -->
                            <div id="edit_employee_subtitle" style="display: none;"></div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #94a3b8; opacity: 1; font-size: 20px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.18)'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#94a3b8';">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Sticky Real-Time KPI Calculation Banner -->
            <div class="kpi-dashboard">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex: 1; flex-wrap: wrap;">
                        <!-- Card 1: Gross Pay -->
                        <div class="kpi-card kpi-card-gross">
                            <div class="kpi-icon-pill" style="background: #dcfce7; color: #16a34a;">
                                <i class="fa fa-arrow-trend-up"></i>
                            </div>
                            <div>
                                <div style="font-size: 10px; font-weight: 700; color: #15803d; letter-spacing: 0.05em; text-transform: uppercase;">Gross Earnings</div>
                                <div id="live_gross_pay" style="font-size: 17px; font-weight: 800; color: #14532d; line-height: 1.2;">₱0.00</div>
                            </div>
                        </div>

                        <!-- Minus Operator -->
                        <div class="kpi-op" title="Minus deductions">−</div>

                        <!-- Card 2: Total Deductions -->
                        <div class="kpi-card kpi-card-deductions">
                            <div class="kpi-icon-pill" style="background: #ffe4e6; color: #e11d48;">
                                <i class="fa fa-arrow-trend-down"></i>
                            </div>
                            <div>
                                <div style="font-size: 10px; font-weight: 700; color: #be123c; letter-spacing: 0.05em; text-transform: uppercase;">Total Deductions</div>
                                <div id="live_total_deductions" style="font-size: 17px; font-weight: 800; color: #881337; line-height: 1.2;">₱0.00</div>
                            </div>
                        </div>

                        <!-- Equals Operator -->
                        <div class="kpi-op" title="Equals net pay">=</div>

                        <!-- Card 3: Net Take-Home Pay -->
                        <div class="kpi-card kpi-card-net">
                            <div class="kpi-icon-pill" style="background: #0284c7; color: #ffffff;">
                                <i class="fa fa-wallet"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 10px; font-weight: 700; color: #0369a1; letter-spacing: 0.05em; text-transform: uppercase;">Net Take-Home Pay</span>
                                    <span style="font-size: 9px; font-weight: 600; background: #e0f2fe; color: #0284c7; padding: 1px 5px; border-radius: 4px;">Live</span>
                                </div>
                                <div id="live_net_pay" style="font-size: 19px; font-weight: 900; color: #0c4a6e; line-height: 1.2;">₱0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="nav-tabs-custom">
                <button type="button" class="tab-btn active edit-modal-tab" data-tab="all">
                    <i class="fa fa-layer-group"></i> All Sections
                </button>
                <button type="button" class="tab-btn edit-modal-tab" data-tab="earnings">
                    <i class="fa fa-plus-circle" style="color: #2563eb;"></i> Earnings & Additions
                    <span class="tab-subtotal-badge" id="subtotal_earnings_badge">₱0.00</span>
                </button>
                <button type="button" class="tab-btn edit-modal-tab" data-tab="statutory">
                    <i class="fa fa-shield-halved" style="color: #e11d48;"></i> Statutory Deductions
                    <span class="tab-subtotal-badge" id="subtotal_statutory_badge">₱0.00</span>
                </button>
                <button type="button" class="tab-btn edit-modal-tab" data-tab="loans">
                    <i class="fa fa-landmark" style="color: #d97706;"></i> Loan Amortizations
                    <span class="tab-subtotal-badge" id="subtotal_loans_badge">₱0.00</span>
                </button>
            </div>

            <!-- Form Container -->
            <form id="editPayslipForm" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_payslip_hidden_id" name="id">

                <div class="modal-body" style="padding: 20px 24px; max-height: 62vh; overflow-y: auto; background: #f8fafc;">
                    
                    <!-- Unified Grid Layout -->
                    <div id="modal_sections_wrapper" style="display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 20px;">
                        
                        <!-- COLUMN 1: Earnings & Additions -->
                        <div id="section_earnings_col">
                            <div class="section-card">
                                <div class="section-header">
                                    <div class="section-title" style="color: #1e3a8a;">
                                        <div class="section-title-icon" style="background: #dbeafe; color: #1d4ed8;">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <span>Earnings & Additions</span>
                                    </div>
                                    <span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                        Subtotal: <span id="subtotal_earnings">₱0.00</span>
                                    </span>
                                </div>

                                <!-- Attendance & Base Pay Group -->
                                <div style="margin-bottom: 14px;">
                                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa fa-business-time text-blue-500"></i> Basic Pay & Standard Time
                                    </div>
                                    
                                    <!-- Work Days & Amount -->
                                    <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_work_days">Work Days</label>
                                            <div class="input-currency-wrapper">
                                                <input type="number" step="0.01" class="custom-input edit-field-qty" id="edit_work_days" name="work_days" placeholder="0">
                                                <span class="qty-suffix">Days</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_work_days_amount">Basic Pay Amount</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_work_days_amount" name="work_days_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Overtime & Amount -->
                                    <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_overtime">OT Hours</label>
                                            <div class="input-currency-wrapper">
                                                <input type="number" step="0.01" class="custom-input edit-field-qty" id="edit_overtime" name="overtime" placeholder="0">
                                                <span class="qty-suffix">Hrs</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_overtime_amount">Overtime Pay</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_overtime_amount" name="overtime_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Extended Regular Hours & Amount -->
                                    <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_ext_reg_hrs">Ext Reg Hours</label>
                                            <div class="input-currency-wrapper">
                                                <input type="number" step="0.01" class="custom-input edit-field-qty" id="edit_ext_reg_hrs" name="ext_reg_hrs" placeholder="0">
                                                <span class="qty-suffix">Hrs</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_ext_reg_hrs_ammount">Ext Reg Pay</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_ext_reg_hrs_ammount" name="ext_reg_hrs_ammount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="height: 1px; background: #f1f5f9; margin: 12px 0;"></div>

                                <!-- Differentials & Holiday Rates -->
                                <div style="margin-bottom: 14px;">
                                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa fa-moon text-indigo-500"></i> Differentials & Holidays
                                    </div>

                                    <!-- Night Diff -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_night_diff_amount">Night Diff</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_night_diff_amount" name="night_diff_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_night_diff_restday_amount">Night Rest Day</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_night_diff_restday_amount" name="night_diff_restday_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Special Holiday -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_rest_special_amount">Special Holiday</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_rest_special_amount" name="rest_special_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_exc_rest_special_amount">Excess Special</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_exc_rest_special_amount" name="exc_rest_special_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Regular Holiday -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_regular_holiday_amount">Reg Holiday</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_regular_holiday_amount" name="regular_holiday_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_exc_regular_holiday_amount">Excess Reg Holiday</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_exc_regular_holiday_amount" name="exc_regular_holiday_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="height: 1px; background: #f1f5f9; margin: 12px 0;"></div>

                                <!-- Leaves, Allowances & Other Earnings -->
                                <div>
                                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa fa-umbrella-beach text-emerald-500"></i> Leaves, Allowances & Incentives
                                    </div>

                                    <!-- Leaves -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_vacation_leave_amount">Vacation Leave</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_vacation_leave_amount" name="vacation_leave_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_sick_leave_amount">Sick Leave</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_sick_leave_amount" name="sick_leave_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- COLA & Commission -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_cola_amount">COLA</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_cola_amount" name="cola_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_commission">Commission</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_commission" name="commission" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hazard Pay & Non-Tax -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                        <div>
                                            <label class="field-label" for="edit_hazard_pay">Hazard Pay</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_hazard_pay" name="hazard_pay" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="field-label" for="edit_non_tax_other">Non-Tax Other</label>
                                            <div class="input-currency-wrapper">
                                                <span class="currency-prefix">₱</span>
                                                <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_non_tax_other" name="non_tax_other" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Regular Other -->
                                    <div class="field-group" style="margin-bottom: 0;">
                                        <label class="field-label" for="edit_regular_other">Regular Other Additions</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-earning" id="edit_regular_other" name="regular_other" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMN 2: Statutory Deductions & Loan Amortizations -->
                        <div id="section_deductions_col">
                            
                            <!-- Card: Statutory & General Deductions -->
                            <div class="section-card" id="card_statutory">
                                <div class="section-header">
                                    <div class="section-title" style="color: #991b1b;">
                                        <div class="section-title-icon" style="background: #fee2e2; color: #b91c1c;">
                                            <i class="fa fa-shield-halved"></i>
                                        </div>
                                        <span>Statutory Deductions</span>
                                    </div>
                                    <span class="badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                        Subtotal: <span id="subtotal_statutory">₱0.00</span>
                                    </span>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                    <div>
                                        <label class="field-label" for="edit_witholding_tax">Withholding Tax</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_witholding_tax" name="witholding_tax" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_sss_contribution">SSS Contribution</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_sss_contribution" name="sss_contribution" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                    <div>
                                        <label class="field-label" for="edit_phic_contribution">PhilHealth (PHIC)</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_phic_contribution" name="phic_contribution" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_hdmf_contribution">Pag-IBIG (HDMF)</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_hdmf_contribution" name="hdmf_contribution" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group" style="margin-bottom: 0;">
                                    <div>
                                        <label class="field-label" for="edit_provident_fund">Provident Fund</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_provident_fund" name="provident_fund" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_rent">Rent / Facility</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-statutory" id="edit_rent" name="rent" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Loan Amortizations & Advances -->
                            <div class="section-card" id="card_loans">
                                <div class="section-header">
                                    <div class="section-title" style="color: #92400e;">
                                        <div class="section-title-icon" style="background: #fef3c7; color: #b45309;">
                                            <i class="fa fa-landmark"></i>
                                        </div>
                                        <span>Loan Amortizations</span>
                                    </div>
                                    <span class="badge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                        Subtotal: <span id="subtotal_loans">₱0.00</span>
                                    </span>
                                </div>

                                <!-- Auto-sync Helper Banner -->
                                <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 7px 10px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-size: 11px; color: #92400e;">
                                    <i class="fa fa-info-circle" style="color: #d97706; font-size: 12px;"></i>
                                    <span>Loan edits will adjust corresponding ledger balances and terms on save.</span>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                    <div>
                                        <label class="field-label" for="edit_sss_loan">SSS Salary Loan</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_sss_loan" name="sss_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_sss_calamity_loan">SSS Calamity</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_sss_calamity_loan" name="sss_calamity_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                    <div>
                                        <label class="field-label" for="edit_hdmf_loan">HDMF Salary Loan</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_hdmf_loan" name="hdmf_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_hdmf_calamity_loan">HDMF Calamity</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_hdmf_calamity_loan" name="hdmf_calamity_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group">
                                    <div>
                                        <label class="field-label" for="edit_sss_emergency_loan">SSS Emergency</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_sss_emergency_loan" name="sss_emergency_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_other_loan">Other / Coop Loan</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_other_loan" name="other_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="field-group" style="margin-bottom: 0;">
                                    <div>
                                        <label class="field-label" for="edit_company_loan">Company Loan</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_company_loan" name="company_loan" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label" for="edit_insurance">Insurance</label>
                                        <div class="input-currency-wrapper">
                                            <span class="currency-prefix">₱</span>
                                            <input type="number" step="0.01" class="custom-input edit-calc-deduction edit-calc-loan" id="edit_insurance" name="insurance" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Redesigned Modal Footer -->
                <div class="modal-footer" style="padding: 14px 24px; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" id="btn_reset_payslip_fields" class="btn btn-default" style="padding: 6px 14px; font-size: 12.5px; font-weight: 600; border-radius: 8px; color: #475569; background: #f8fafc; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;" title="Discard edits and restore original values">
                            <i class="fa fa-undo" style="font-size: 11px;"></i> Reset to Original
                        </button>
                        <span style="font-size: 11px; color: #94a3b8; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa fa-check-circle" style="color: #10b981;"></i> Auto-sync enabled
                        </span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 7px 16px; font-size: 13px; font-weight: 600; border-radius: 8px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn_save_payslip" style="padding: 7px 20px; font-size: 13px; font-weight: 700; border-radius: 8px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3); display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                            <i class="fa fa-save" style="font-size: 12px;"></i>
                            <span id="btn_save_payslip_text">Save Changes</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/payslip/payslip.js') }}"></script>
@endsection