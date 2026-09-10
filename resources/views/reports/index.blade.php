@extends('layouts.app')
@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Generate Reports</h1>
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden max-w-4xl">
    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-700 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-500"></i> Report Configuration
        </h2>
    </div>
    
    <div class="p-6">
        <form method="POST" action="/reports/view-report" class="space-y-6">
            {{csrf_field()}}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Select Report -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Select Report :</label>
                    <select id="report_type" name="report_type" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="Payroll">PAYROLL</option>
                        <option value="Sss">SSS</option>
                        <option value="Pag-IBIG">Pag-IBIG</option>
                        <option value="WITHOLDING TAX">WITHOLDING TAX</option>
                        <option value="PHILHEALTH">PHILHEALTH </option>
                        <option value="SSS LOANS">SSS LOANS</option>
                        <option value="Pag-IBIG LOANS">Pag-IBIG LOANS</option>
                        <option value="Pag-IBIG CALAMITY LOANS">Pag-IBIG CALAMITY LOANS</option>
                        <option value="Pag-IBIG SAFE LOANS">Pag-IBIG SAFE LOANS</option>
                        <option value="13 MONTH">THIRTEEN MONTH</option>
                        <option value="ALPHA LIST">ALPHA LIST</option>
                        <option value="ALPHA LIST (MONTHLY)">ALPHA LIST (MONTHLY)</option>
                        <option value="EMPLOYEE INFORMATION">EMPLOYEE INFORMATION</option>
                    </select>
                </div>
                
                <!-- Select Department -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Select Department :</label>
                    <select name="department" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        @foreach($department as $departments)
                        <option value="{{$departments}}">{{strtoupper($departments)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Month Selection -->
                <div id="month">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Month :</label>
                    <input type="month" name="monthRep" id="monthRep" value="{{date('Y-m')}}" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                <!-- Quarter Selection -->
                <div id="quarter" style="display:none">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Quarter :</label>
                    <select id="quarterYear" name="quarterYear" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="1">First Half - From Nov 26 last year to May 25 current year</option>
                        <option value="2">Second Half - From May 26 current year to Nov 25 current year</option>
                    </select>
                </div>

                <!-- Payroll Number -->
                <div id="payroll_no">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Payroll No. :</label>
                    <select id="payroll_number" name="payroll_number" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                <button type="button" id="btn-import-payroll-csv" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-import"></i> Import Payroll CSV
                </button>
                <button type="submit" formtarget="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payroll CSV Import Modal -->
<div class="modal fade" id="importPayrollModal" tabindex="-1" role="dialog" aria-labelledby="importPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h4 class="modal-title font-bold text-slate-800 text-lg" id="importPayrollModalLabel">Import Payroll Records from CSV</h4>
                    <p class="text-xs text-slate-500 font-normal">Bulk upload pre-calculated payroll runs via CSV template</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-6">
                <!-- Step 1: Format Guide -->
                <div id="payroll-step-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 p-3.5 bg-emerald-50/80 border border-emerald-200 rounded-xl">
                        <div class="text-xs text-emerald-950 leading-relaxed">
                            <div class="font-bold flex items-center gap-1.5 text-emerald-800 mb-0.5">
                                <i class="fa fa-file-excel text-emerald-600 text-sm"></i> Recommended Workflow (Excel to CSV):
                            </div>
                            Download our pre-formatted Excel template containing all 59 columns, populate payroll calculations in Excel, and click <strong>File &gt; Save As &gt; CSV (*.csv)</strong> before importing.
                        </div>
                        <a href="{{ route('reports.download-template') }}" class="btn btn-success text-xs font-semibold flex items-center justify-center gap-1.5 whitespace-nowrap shadow-sm shrink-0">
                            <i class="fa fa-download text-xs"></i> Download Excel Template (.xlsx)
                        </a>
                    </div>

                    <p class="text-xs text-slate-600 mb-4">The CSV columns must match the headers listed below. This file contains 59 columns representing all indicators, calculations, and deductions necessary to compile correct payroll reports.</p>
                    
                    <div style="max-height: 280px; overflow-y: auto;" class="border border-slate-200 rounded-xl mb-5 shadow-inner">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="sticky top-0 bg-slate-100/95 backdrop-blur-xs border-b border-slate-200">
                                <tr>
                                    <th class="px-3 py-2 font-semibold text-slate-600 uppercase text-[10px]">Header / Column Name</th>
                                    <th class="px-3 py-2 font-semibold text-slate-600 uppercase text-[10px]">Type</th>
                                    <th class="px-3 py-2 font-semibold text-slate-600 uppercase text-[10px]">Required</th>
                                    <th class="px-3 py-2 font-semibold text-slate-600 uppercase text-[10px]">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">employee_code</td><td class="px-3 py-1.5 text-slate-500">Integer</td><td class="px-3 py-1.5 text-red-600 font-bold">Yes</td><td class="px-3 py-1.5 text-slate-500">ID of employee from DB</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">department</td><td class="px-3 py-1.5 text-slate-500">String</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Department Name</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">payroll_number</td><td class="px-3 py-1.5 text-slate-500">Integer</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">1 - 5</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">monthly_record</td><td class="px-3 py-1.5 text-slate-500">Integer</td><td class="px-3 py-1.5 text-red-600 font-bold">Yes</td><td class="px-3 py-1.5 text-slate-500">Month index (1 - 12)</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">year</td><td class="px-3 py-1.5 text-slate-500">Integer</td><td class="px-3 py-1.5 text-red-600 font-bold">Yes</td><td class="px-3 py-1.5 text-slate-500">Payroll Year (e.g. 2026)</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">date_from</td><td class="px-3 py-1.5 text-slate-500">Date</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">YYYY-MM-DD</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">date_to</td><td class="px-3 py-1.5 text-slate-500">Date</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">YYYY-MM-DD</td></tr>
                                <tr class="bg-blue-50/60 font-semibold text-blue-900"><td colspan="4" class="px-3 py-2 text-center text-[11px] uppercase tracking-wider">Earnings & Attendance (Numeric / Decimals)</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">work_days</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Days worked</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">work_days_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Total base pay earned</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">overtime</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">OT Hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">overtime_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">OT Pay</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">ext_reg_hrs</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Extended Regular Hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">ext_reg_hrs_ammount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Extended Regular Amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">night_diff</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Night differential hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">night_diff_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Night diff amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">night_diff_restday</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Night diff restday hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">night_diff_restday_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Night diff restday amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">rest_special</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday rest hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">rest_special_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday rest amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday_day</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday day count</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday_day_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday day amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday_day_minimum</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday day minimum</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">regular_holiday_day_minimum_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Regular holiday day min amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">special_holiday_day</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday day count</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">special_holiday_day_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday day amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">special_holiday_day_minimum</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday day minimum</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">special_holiday_day_minimum_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Special holiday day min amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">absent</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Days absent</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">absent_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Deduction for absences</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">late</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Hours late</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">late_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Deduction for lates</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">sick_leave</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Sick leave days used</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">sick_leave_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Sick leave amount paid</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">vacation_leave</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">VL days used</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">vacation_leave_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">VL amount paid</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">service_leave</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Service leave days used</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">service_leave_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Service leave amount paid</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">total_basic_pay</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Basic pay subtotal</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">cola</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">COLA count/hours</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">cola_amount</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">COLA amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">thirteen_month</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Thirteen month pay amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">non_tax_other</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Non taxable allowances</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">total_other_pay</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Other earnings subtotal</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">gross_pay</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Total gross earnings</td></tr>
                                <tr class="bg-rose-50/60 font-semibold text-rose-900"><td colspan="4" class="px-3 py-2 text-center text-[11px] uppercase tracking-wider">Tax & Contributions Deductions</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">witholding_tax</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Withholding Tax amount</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">sss_contribution</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">SSS Employee contribution</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">phic_contribution</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">PhilHealth contribution</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">hdmf_contribution</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Pag-IBIG contribution</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">provident_fund</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">SSS Provident Fund contribution</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">sss_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">SSS regular loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">sss_calamity_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">SSS calamity loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">hdmf_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Pag-IBIG regular loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">hdmf_calamity_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Pag-IBIG calamity loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">company_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Company loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">other_loan</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Other loan deduction</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-medium text-slate-700">total_deduction</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Total deductions subtotal</td></tr>
                                <tr><td class="px-3 py-1.5 font-mono font-bold text-slate-900">net_pay</td><td class="px-3 py-1.5 text-slate-500">Numeric</td><td class="px-3 py-1.5 text-slate-400">No</td><td class="px-3 py-1.5 text-slate-500">Net pay (Take home)</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="button" id="btn-proceed-payroll-upload" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5">
                            <span>Proceed to Upload</span>
                            <i class="fa fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Upload File Input -->
                <div id="payroll-step-2" style="display: none;">
                    <form id="payrollImportForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="p-6 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50 text-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-cloud-upload text-xl"></i>
                            </div>
                            <label for="payroll_import_file" class="block text-sm font-bold text-slate-700 mb-1 cursor-pointer">Choose CSV File</label>
                            <p class="text-xs text-slate-400 mb-3">Select the exported or prepared CSV file containing 59 columns</p>
                            <input type="file" id="payroll_import_file" name="import_file" class="form-control max-w-sm mx-auto text-xs" accept=".csv,text/csv,text/plain" required>
                        </div>
                        <div id="payroll-import-results" style="display:none;" class="alert mb-4"></div>
                        <div class="flex items-center justify-center gap-2 pt-2">
                            <button type="button" id="btn-back-payroll-step-1" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Back</button>
                            <button type="submit" id="btn-submit-payroll-import" class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5">
                                <i class="fa fa-check text-xs"></i>
                                <span>Import Now</span>
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
<script type="text/javascript" src="{{ asset('js/report/report.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#btn-import-payroll-csv').on('click', function() {
            $('#payroll-step-1').show();
            $('#payroll-step-2').hide();
            $('#payroll_import_file').val('');
            $('#payroll-import-results').hide().empty();
            $('#importPayrollModal').modal('show');
        });

        $('#btn-proceed-payroll-upload').on('click', function() {
            $('#payroll-step-1').hide();
            $('#payroll-step-2').show();
        });

        $('#btn-back-payroll-step-1').on('click', function() {
            $('#payroll-step-2').hide();
            $('#payroll-step-1').show();
        });

        $('#payrollImportForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var $btn = $('#btn-submit-payroll-import');
            var originalBtnHtml = $btn.html();

            // Disable buttons and show spinner
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1.5"></i> Importing Payroll...');
            $('#btn-back-payroll-step-1, #importPayrollModal .close').prop('disabled', true);
            $('#payroll-import-results').hide().removeClass('alert-success alert-danger alert-warning').empty();

            // Show non-blocking Alertify ongoing notification
            var loadingAlert = alertify.notify('<div class="flex items-center gap-2"><i class="fa fa-spinner fa-spin text-blue-500"></i> Importing payroll records, please wait...</div>', 'message', 0);

            $.ajax({
                url: '/reports/batch-import',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (loadingAlert && typeof loadingAlert.dismiss === 'function') {
                        loadingAlert.dismiss();
                    }
                    $btn.prop('disabled', false).html(originalBtnHtml);
                    $('#btn-back-payroll-step-1, #importPayrollModal .close').prop('disabled', false);

                    var hasFailed = response.failed && response.failed.length > 0;

                    if (response.success > 0 && !hasFailed) {
                        // 100% Success Flow
                        $('#importPayrollModal').modal('hide');
                        alertify.success('<div class="flex items-center gap-2"><i class="fa fa-check-circle text-emerald-400"></i> <strong>Success!</strong> ' + response.message + '</div>', 5);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else if (response.success > 0 && hasFailed) {
                        // Partial Success Flow
                        alertify.warning('Payroll import completed with ' + response.failed.length + ' error(s). Please review failed rows below.');
                        var html = '<strong>' + response.message + '</strong>';
                        html += '<hr class="my-2 border-amber-200"><p class="mb-1 font-bold text-amber-900">Failed rows to fix:</p><ul class="pl-4 mb-0 text-xs space-y-1">';
                        response.failed.forEach(function(item) {
                            html += '<li><strong>Row ' + item.row + ':</strong> ' + item.reason + '</li>';
                        });
                        html += '</ul>';
                        $('#payroll-import-results').addClass('alert-warning').html(html).show();
                    } else {
                        // 0 Succeeded Flow
                        alertify.error(response.message || 'Import failed. No payroll records were imported.');
                        var html = '<strong>' + (response.message || 'Import Failed') + '</strong>';
                        if (hasFailed) {
                            html += '<hr class="my-2 border-rose-200"><p class="mb-1 font-bold text-rose-900">Row Errors:</p><ul class="pl-4 mb-0 text-xs space-y-1">';
                            response.failed.forEach(function(item) {
                                html += '<li><strong>Row ' + item.row + ':</strong> ' + item.reason + '</li>';
                            });
                            html += '</ul>';
                        }
                        $('#payroll-import-results').addClass('alert-danger').html(html).show();
                    }
                },
                error: function(xhr) {
                    if (loadingAlert && typeof loadingAlert.dismiss === 'function') {
                        loadingAlert.dismiss();
                    }
                    $btn.prop('disabled', false).html(originalBtnHtml);
                    $('#btn-back-payroll-step-1, #importPayrollModal .close').prop('disabled', false);

                    var errorMsg = 'An unexpected error occurred during payroll import.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alertify.error(errorMsg);
                    $('#payroll-import-results').addClass('alert-danger').html('<strong>' + errorMsg + '</strong>').show();
                }
            });
        });
    });
</script>
@endsection