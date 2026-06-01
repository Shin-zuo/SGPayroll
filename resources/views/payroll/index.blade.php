@extends('layouts.app')
@section('content')

@if($employee->count()!=0)
<div class="mb-4">
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-base font-bold text-slate-800">{{$employee->first()->department}}</h3>
            <div class="flex space-x-4 items-center">
                <div class="flex items-center space-x-2">
                    <input class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" type="checkbox" value="1" id="13Month" name="13Month">
                    <label class="text-sm font-medium text-slate-700" for="13Month">Compute 13th month</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" type="checkbox" value="1" id="endMonth" name="endMonth">
                    <label class="text-sm font-medium text-slate-700" for="endMonth">End of Month</label>
                </div>
                <button type="button" id="insertFinishData" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-1.5 rounded flex items-center transition-colors">
                    <i class="fa fa-save mr-1.5"></i> Save Data
                </button>
            </div>
        </div>
        
        <input type="hidden" id="payrollType" value="{{$employee->first()->payroll_type}}">
        
        <div class="p-4 bg-white">
            @if(session()->has('message'))
                <div class="mb-4 rounded-md bg-green-50 p-3 border border-green-200 text-green-700 text-sm">
                    {{ session()->get('message') }}
                </div>
            @endif
            
            <form action="/payroll" method="get" class="flex flex-wrap items-end gap-4">
                {{csrf_field()}}
                <input type="hidden" id="employeePayroll_type" name="employeePayroll_type" value="{{$employee->first()->payroll_type}}">
                <input type="hidden" id="deptCode" name="deptCode" value="{{$employee->first()->department}}">
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Payroll No.</label>
                    <select class="text-sm border-slate-300 rounded-md p-1.5 focus:ring-1 focus:ring-blue-500" id="payroll_no" name="payroll_no">
                        @if($employee->first()->payroll_type==1 || $employee->first()->payroll_type==2 || empty($employee->first()->payroll_type))
                            <option value="1">1</option>
                            <option value="2">2</option>
                        @elseif($employee->first()->payroll_type==3 || $employee->first()->payroll_type==4)
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        @endif
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Period From</label>
                    <input type="date" class="text-sm border-slate-300 rounded-md p-1.5 focus:ring-1 focus:ring-blue-500" id="date_from" name="date_from">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Period To</label>
                    <input type="date" class="text-sm border-slate-300 rounded-md p-1.5 focus:ring-1 focus:ring-blue-500" id="date_to" name="date_to">
                </div>
                
                <div>
                    <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-4 py-1.5 rounded border border-slate-300 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@foreach($employee as $employees)
<form id="payrollCompute" class="mb-6 payroll-table-main">
    {{csrf_field()}}
    <input type="hidden" id="employee" name="employee" value="{{$employees->id}}">
    <input type="hidden" id="deptName" name="deptName" value="{{$employees->department}}">
    
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-4 py-2 border-b border-blue-700">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
                <i class="fa fa-user"></i> {{$employees->full_name}}
            </h4>
        </div>
        
        <div class="p-0 overflow-x-auto">
            <!-- Basic Pay Table -->
            <table class="w-full text-left border-collapse border-b border-slate-200 text-xs">
                <thead>
                    <tr class="bg-blue-50 text-blue-800 font-semibold border-b border-slate-200">
                        <th class="px-2 py-1.5 border-r border-slate-200 text-center" colspan="13">Basic Pay Earnings (Hours/Days)</th>
                    </tr>
                    <tr class="bg-slate-50 text-slate-600 font-medium border-b border-slate-200 text-[10px] uppercase tracking-wider">
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Work(days)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">OT(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Ext.Reg(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Night Diff(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">ND Rest(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Rest Day(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Rest(ehrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Reg Hol(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">Reg Hol(ehrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">RD on Reg(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">RD on Reg(ehrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">RD on Spl(hrs)</th>
                        <th class="px-1 py-1.5 border-r border-slate-200 whitespace-nowrap text-center">RD on Spl(ehrs)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="work_days" name="work_days"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="overtime_hours" name="overtime_hours"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="extra_regular_hour" name="extra_regular_hour"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="night_diff" name="night_diff"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="night_diff_restday" name="night_diff_restday"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="rest_special" name="rest_special"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="rest_special_exc" name="rest_special_exc"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="regular_holiday_hour" name="regular_holiday_hour"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="regular_holiday_hour_exc" name="regular_holiday_hour_exc"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="restday_on_regular" name="restday_on_regular"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="restday_on_regular_exc" name="restday_on_regular_exc"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="restday_on_special" name="restday_on_special"></td>
                        <td class="p-1 border-r border-slate-200"><input type="number" class="w-full text-xs p-1 border rounded" id="restday_on_special_exc" name="restday_on_special_exc"></td>
                    </tr>
                </tbody>
            </table>

            <!-- Debit/Credit Table -->
            <table class="w-full text-left border-collapse border-b border-slate-200 text-xs mt-4">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th colspan="2" class="px-2 py-1.5 border-r border-slate-200 text-center bg-red-50 text-red-800 font-semibold">Debit</th>
                        <th colspan="4" class="px-2 py-1.5 border-r border-slate-200 text-center bg-yellow-50 text-yellow-800 font-semibold">Credit</th>
                        <th colspan="2" class="px-2 py-1.5 border-r border-slate-200 text-center bg-purple-50 text-purple-800 font-semibold">Non-Tax Benefits</th>
                        <th colspan="2" class="px-2 py-1.5 border-r border-slate-200 text-center bg-green-50 text-green-800 font-semibold">Non-Tax Other Pay</th>
                        <th rowspan="2" class="px-2 py-1.5 text-center bg-slate-100 text-slate-800 font-bold border-l border-slate-200">Excess Hours</th>
                        <th rowspan="2" class="px-2 py-1.5 text-center bg-blue-100 text-blue-800 font-bold border-l border-slate-200">Gross Pay</th>
                    </tr>
                    <tr class="text-[10px] uppercase tracking-wider font-medium border-b border-slate-200">
                        <th class="px-1 py-1.5 bg-red-50 text-red-600 border-r border-slate-200 text-center">Absent(days)</th>
                        <th class="px-1 py-1.5 bg-red-50 text-red-600 border-r border-slate-200 text-center">UT(hrs)</th>
                        <th class="px-1 py-1.5 bg-yellow-50 text-yellow-600 border-r border-slate-200 text-center">Reg Hol(days)</th>
                        <th class="px-1 py-1.5 bg-yellow-50 text-yellow-600 border-r border-slate-200 text-center">Spl Hol(days)</th>
                        <th class="px-1 py-1.5 bg-yellow-50 text-yellow-600 border-r border-slate-200 text-center">Reg Hol(Min)</th>
                        <th class="px-1 py-1.5 bg-yellow-50 text-yellow-600 border-r border-slate-200 text-center">Spl Hol(Min)</th>
                        <th class="px-1 py-1.5 bg-purple-50 text-purple-600 border-r border-slate-200 text-center">VL(days)</th>
                        <th class="px-1 py-1.5 bg-purple-50 text-purple-600 border-r border-slate-200 text-center">SL(days)</th>
                        <th class="px-1 py-1.5 bg-green-50 text-green-600 border-r border-slate-200 text-center">Other NT</th>
                        <th class="px-1 py-1.5 bg-green-50 text-green-600 text-center">13th Month</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-1 border-r border-slate-200 bg-red-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="absent" name="absent"></td>
                        <td class="p-1 border-r border-slate-200 bg-red-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="underTime" name="underTime"></td>
                        <td class="p-1 border-r border-slate-200 bg-yellow-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="regular_holiday" name="regular_holiday"></td>
                        <td class="p-1 border-r border-slate-200 bg-yellow-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="special_holiday" name="special_holiday"></td>
                        <td class="p-1 border-r border-slate-200 bg-yellow-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="regular_holiday_minimum" name="regular_holiday_minimum"></td>
                        <td class="p-1 border-r border-slate-200 bg-yellow-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="special_holiday_minimum" name="special_holiday_minimum"></td>
                        <td class="p-1 border-r border-slate-200 bg-purple-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="vacation_leave" name="vacation_leave"></td>
                        <td class="p-1 border-r border-slate-200 bg-purple-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="sick_leave" name="sick_leave"></td>
                        <td class="p-1 border-r border-slate-200 bg-green-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="other_pay" name="other_pay"></td>
                        <td class="p-1 border-r border-slate-200 bg-green-50/30"><input type="number" class="w-full text-xs p-1 border rounded" id="thirteen_month" name="thirteen_month"></td>
                        <td class="p-1 border-l border-r border-slate-200 bg-slate-50"><input type="number" class="w-full text-xs p-1 border rounded bg-transparent font-semibold" id="excess_amount" name="excess_amount" disabled></td>
                        <td class="p-1 border-l border-slate-200 bg-blue-50/50"><input type="number" class="w-full text-xs p-1 border rounded bg-transparent font-bold text-blue-700" id="gross_pay" name="gross_pay" disabled></td>
                    </tr>
                </tbody>
            </table>

            <!-- Contributions & Loans -->
            <table class="w-full text-left border-collapse text-xs mt-4">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th colspan="4" class="px-2 py-1.5 border-r border-slate-200 text-center bg-orange-50 text-orange-800 font-semibold">Contributions</th>
                        <th colspan="7" class="px-2 py-1.5 border-r border-slate-200 text-center bg-teal-50 text-teal-800 font-semibold">Loans</th>
                        <th rowspan="2" class="px-2 py-1.5 text-center bg-green-100 text-green-800 font-bold border-l border-slate-200">Net Pay</th>
                    </tr>
                    <tr class="text-[10px] uppercase tracking-wider font-medium border-b border-slate-200">
                        <th class="px-1 py-1.5 bg-orange-50 text-orange-600 border-r border-slate-200 text-center">W.Tax</th>
                        <th class="px-1 py-1.5 bg-orange-50 text-orange-600 border-r border-slate-200 text-center">SSS</th>
                        <th class="px-1 py-1.5 bg-orange-50 text-orange-600 border-r border-slate-200 text-center">PHIC</th>
                        <th class="px-1 py-1.5 bg-orange-50 text-orange-600 border-r border-slate-200 text-center">HDMF</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">Insure</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">SSS</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">Calamity</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">Pag-IBIG</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">Cal(HDMF)</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 border-r border-slate-200 text-center">Advance</th>
                        <th class="px-1 py-1.5 bg-teal-50 text-teal-600 text-center">Coop</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border-r border-slate-200 bg-orange-50/30 text-center font-medium" name="witholding_tax">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-orange-50/30 text-center font-medium" name="sss_deduction">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-orange-50/30 text-center font-medium" name="phil_deduction">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-orange-50/30 text-center font-medium" name="pagibig_deduction">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="insurance">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="sss_loan">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="calamity_loan">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="hdmf_loan">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="hdmf_calamity_loan">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="company_loan">0.00</td>
                        <td class="p-2 border-r border-slate-200 bg-teal-50/30 text-center font-medium" name="rent_loan">0.00</td>
                        <td class="p-2 border-l border-slate-200 bg-green-50 text-center text-sm font-bold text-green-700" name="net_pay">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Hidden Inputs for JS Computation -->
        <input type="hidden" id="nt_pay" name="nt_pay">
        <input type="hidden" id="basic_amount" name="basic_amount" value="">
        <input type="hidden" id="work_days_amount" name="work_days_amount" value="">
        <input type="hidden" id="over_time_amount" name="over_time_amount" value="">
        <input type="hidden" id="extra_regular_hours_amount" name="extra_regular_hours_amount" value="">
        <input type="hidden" id="night_diff_amount" name="night_diff_amount" value="">
        <input type="hidden" id="night_diff_restday_amount" name="night_diff_restday_amount" value="">
        <input type="hidden" id="rest_special_amount" name="rest_special_amount" value="">
        <input type="hidden" id="rest_special_exc_amount" name="rest_special_exc_amount" value="">
        <input type="hidden" id="regular_holiday_hour_amount" name="regular_holiday_hour_amount" value="">
        <input type="hidden" id="regular_holiday_hour_exc_amount" name="regular_holiday_hour_exc_amount" value="">
        <input type="hidden" id="restday_on_regular_amount" name="restday_on_regular_amount" value="">
        <input type="hidden" id="ot_pay_total" name="ot_pay_total" value="">
        <input type="hidden" id="holiday_pay_total" name="holiday_pay_total" value="">
        <input type="hidden" id="vacation_leave_amount" name="vacation_leave_amount" value="">
        <input type="hidden" id="sick_leave_amount" name="sick_leave_amount" value="">
        <input type="hidden" id="service_leave_amount" name="service_leave_amount" value="">
        <input type="hidden" id="leave_pay_total" name="leave_pay_total" value="">
        <input type="hidden" id="other_taxable_pay_total" name="other_taxable_pay_total" value="">
        <input type="hidden" id="other_non_taxable_pay_total" name="other_non_taxable_pay_total" value="">
        <input type="hidden" id="gross_pay_total" name="gross_pay_total" value="">
        <input type="hidden" id="withholding_tax_total" name="withholding_tax_total" value="">
        <input type="hidden" id="sss_contribution_total" name="sss_contribution_total" value="">
        <input type="hidden" id="phic_contribution_total" name="phic_contribution_total" value="">
        <input type="hidden" id="hdmf_contribution_total" name="hdmf_contribution_total" value="">
        <input type="hidden" id="union_contribution_total" name="union_contribution_total" value="">
        <input type="hidden" id="insurance_contribution_total" name="insurance_contribution_total" value="">
        <input type="hidden" id="sss_loan_total" name="sss_loan_total" value="">
        <input type="hidden" id="sss_provident_fund" name="sss_provident_fund" value="">
        <input type="hidden" id="sss_calamity_loan_total" name="sss_calamity_loan_total" value="">
        <input type="hidden" id="hdmf_loan_total" name="hdmf_loan_total" value="">
        <input type="hidden" id="hdmf_calamity_loan_total" name="hdmf_calamity_loan_total" value="">
        <input type="hidden" id="cola" name="cola" value="">
        <input type="hidden" id="other_loan_total" name="other_loan_total" value="">
        <input type="hidden" id="net_pay_total" name="net_pay_total" value="">
        <input type="hidden" id="regular_holiday_amount" name="regular_holiday_amount" value="">
        <input type="hidden" id="special_holiday_amount" name="special_holiday_amount" value="">
        <input type="hidden" id="regular_holiday_minimum_amount" name="regular_holiday_minimum_amount" value="">
        <input type="hidden" id="special_holiday_minimum_amount" name="special_holiday_minimum_amount" value="">
    </div>
</form>
@endforeach

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/payroll/payrollComputation.js"></script>