@extends('layouts.app')
@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Generate Payslip</h1>
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden max-w-4xl">
    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-slate-700 flex items-center gap-2">
            <i class="fas fa-money-check-alt text-blue-500"></i> Payslip Configuration
        </h2>
    </div>
    
    <div class="p-6">
        <form method="POST" action="/payslip/view-payslip" class="space-y-6">
            {{csrf_field()}}
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Department Selection -->
                <div class="{{ $errors->has('department') ? 'has-error' : '' }}">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Department :</label>
                    <select id="department" name="department" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm {{ $errors->has('department') ? 'border-red-500' : '' }}">
                        <option value="">-----SELECT DEPARTMENT-----</option>
                        @foreach($department as $departments)
                        <option value="{{strtoupper($departments->department_name)}}">{{strtoupper($departments->department_name)}} - {{strtoupper($departments->department_code)}}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Date Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Date :</label>
                    <input type="month" id="date_payslip" name="date_payslip" value="{{date('Y-m')}}" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
                
                <!-- Payroll Number -->
                <div>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end bg-slate-50 p-4 rounded border border-slate-100">
                <!-- Print All Checkbox -->
                <div class="flex items-center h-full pt-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" id="print_all" name="print_all" value="1" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-bold text-slate-700">Print All Employees</span>
                    </label>
                </div>
                
                <!-- Employee Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Specific Employee ID :</label>
                    <select id="employee_id" name="employee_id" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <!-- Populated via JS -->
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" formtarget="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Generate Payslip
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/payslip/payslip.js"></script>