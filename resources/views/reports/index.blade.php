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

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" formtarget="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/report/report.js"></script>