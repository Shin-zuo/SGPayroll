@extends('layouts.app')
@section('content')
<<<<<<< HEAD
<div class="panel panel-default">
    <div class="panel-heading">Edit Previous Payroll Summary</div>
    <div class="panel-body">
        {{--<label class="legend-label">Date Period</label>--}}
        {{--<hr class="legend-hr">--}}
        {{--<form class="form-horizontal">--}}
            {{--<div class="form-group">--}}
                {{--<label for="inputBP" class="col-sm-1 control-label">Year</label>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<select class="form-control">--}}
                        {{--<option>1</option>--}}
                        {{--<option>2</option>--}}
                        {{--<option>3</option>--}}
                        {{--<option>4</option>--}}
                        {{--<option>5</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="col-md-4 text-center">--}}
                    {{--<div class="checkbox">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox"> Month by Month--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<label for="inputBP" class="col-sm-1 control-label">Month</label>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<select class="form-control">--}}
                        {{--<option>1</option>--}}
                        {{--<option>2</option>--}}
                        {{--<option>3</option>--}}
                        {{--<option>4</option>--}}
                        {{--<option>5</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}

        <label class="legend-label">Select Employee</label>
        <hr class="legend-hr">
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputBP" class="col-sm-2 control-label">Department:</label>
                <div class="col-sm-3">
                    <select class="form-control" id="department">
                        <option selected>----SELECT DEPARTMENT----</option>
                        @foreach($department as $departments)
                        <option value="{{$departments->department_name}}">{{$departments->department_name}} - {{$departments->department_code}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="inputBP" class="col-sm-2 control-label">Employee ID:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="employee">
                    </select>
                </div>
            </div>
        </form>

        <label class="legend-label">Employee's Pay and Contributions</label> 
        <hr class="legend-hr">
        <div class="row">
            <div class="col-md-5">
                <form class="form-horizontal">
                    {{--<div class="form-group">--}}
                        {{--<label for="inputBP" class="col-sm-5 control-label">Basic Pay</label>--}}
                        {{--<div class="col-sm-7">--}}
                            {{--<input type="number" class="input-sm form-control" id="inputBP" name="inputBP">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <input type="hidden" name="employee_id" id="employee_id">
                    <input type="hidden" name="date_from" id="date_from">
                    <input type="hidden" name="date_to" id="date_to">
                    <input type="hidden" name="endMonth" id="endMonth">
                    <input type="hidden" name="payroll_no" id="payroll_no">
                    <input type="hidden" name="payroll_id" id="payroll_id">
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Work days</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputWD" name="inputWD" placeholder="Day(s)">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputWD_amount" name="inputWD_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Overtime</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputOT" name="inputOT" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputOT_amount" name="inputOT_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Ext.Reg(Hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputER" name="inputER" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputER_amount" name="inputER_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Night Diff(hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputND" name="inputND" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputND_amount" name="inputND_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day (hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputRS" name="inputRS" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputRS_amount" name="inputRS_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day (ehrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputERS" name="inputERS" placeholder="EHrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputERS_amount" name="inputERS_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Regular Holiday(hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputRH" name="inputRH" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputRH_amount" name="inputRH_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Regular Holiday(ehrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputERH" name="inputERH" placeholder="EHrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputERH_amount" name="inputERH_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day on Regular(hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputRDR" name="inputRDR" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputRDR_amount" name="inputRDR_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day on Regular(ehrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputERDR" name="inputERDR" placeholder="EHrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputERDR_amount" name="inputERDR_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day on Special(hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputRDS" name="inputRDS" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputRDS_amount" name="inputRDS_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Rest Day on Special(ehrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputERDS" name="inputERDS" placeholder="EHrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputERDS_amount" name="inputERDS_amount" placeholder="Amount">
                        </div>
                    </div>
                    <label class="legend-label-1">Debit</label> 
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Absent(days)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputAbsent" name="inputAbsent" placeholder="Day(s)">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputAbsent_amount" name="inputAbsent_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Undertime(hrs)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputUT" name="inputUT" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputUT_amount" name="inputUT_amount" placeholder="Amount">
                        </div>
                    </div>
                    <label class="legend-label-1">Credit</label>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Regular Holiday(days)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputCRH" name="inputCRH" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputCRH_amount" name="inputCRH_amount" placeholder="Amount">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Special Holiday(days)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputCSH" name="inputCSH" placeholder="Hrs">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputCSH_amount" name="inputCSH_amount" placeholder="Amount">
                        </div>
                    </div> 
                    <label class="legend-label-1">Non-Taxable Benefits</label>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Vacation Leave(days)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputIL" name="inputIL" placeholder="Day(s)">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputIL_amount" name="inputIL_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Sick Leave(days)</label>
                        <div class="col-sm-3">
                            <input type="number" class="input-sm form-control" id="inputSL" name="inputSL" placeholder="Day(s)">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="input-sm form-control" id="inputSL_amount" name="inputSL_amount" placeholder="Amount">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form class="form-horizontal">
                    <label class="legend-label-1">Non-Taxable Other Pay</label>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Other Nt Pay</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputNTP_amount" name="inputNTP_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Other Pay</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputOther_amount" name="inputOther_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">13th month pay</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="input13M_amount" name="input13M_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Cola</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputCola_amount" name="inputCola_amount" placeholder="Amount">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Excess Hours</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputEH_amount" name="inputEH_amount" placeholder="Amount" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBP" class="col-sm-6 control-label text-danger">Gross Pay</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputGP_amount" name="inputGP_amount" placeholder="Amount" disabled="">
                        </div>
                    </div>
                    <hr>
                    <label class="legend-label-1">Contributions</label>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Witholding Tax</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputWT_amount" name="inputWT_amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">SSS</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputSSS_contrib" name="inputSSS_contrib" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">PHIC</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputPHIC_contrib" name="inputPHIC_contrib" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">HDMF</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputHDMF_contrib" name="inputHDMF_contrib" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Insurance</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputInsurance" name="inputInsurance" placeholder="Amount">
                        </div>
                    </div>
                    <label class="legend-label-1">Loans</label>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">SSS</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputSSS_loan" name="inputSSS_loan" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Pag-IBIG</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputHDMF_loan" name="inputHDMF_loan" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Coop</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputCoop_loan" name="inputCoop_loan" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Others</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputOther_loan" name="inputOther_loan" placeholder="Amount">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputBP" class="col-sm-6 control-label text-danger">Net Pay</label>
                        <div class="col-sm-6">
                            <input type="number" class="input-sm form-control" id="inputNP_amount" name="inputNP_amount" placeholder="Amount">
                        </div>
                    </div>

                    
            </div>
            <div class="col-md-3">
                <form>
                    <label class="legend-label-1">Taxable Compensation income</label>
                    <div class="form-group">
                        <label for="input13">13th Month Pay and Other Benefits</label>
                        <input type="number" class="form-control input-sm" id="input13">
                    </div>
                </form>
                <hr class="legend-hr">
                <form>
                    <label class="legend-label-1">Non-Taxable Compensation income</label>
                    <div class="form-group">
                        <label for="input13">13th Month Pay and Other Benefits</label>
                        <input type="number" class="form-control input-sm" id="input13">
                    </div>
                    <div class="form-group">
                        <label for="input13">Salaries and Other Forms of Compensation</label>
                        <input type="number" class="form-control input-sm" id="input13">
                    </div>
                </form>
            </div>
            <div class="col-md-3 pull-right">
                <button type="button" id="Recompute" class="btn btn-success"><i class="fas fa-calculator"></i> Recompute</button>
                <button type="button" id="updateData" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save Update</button>
            </div>
        </div>
=======
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-xl font-bold text-slate-800">Edit Previous Payroll Summary</h1>
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden mb-4">
    <div class="bg-slate-50 px-4 py-2 border-b border-slate-200">
        <h3 class="text-sm font-semibold text-slate-700">Select Employee</h3>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Department</label>
                <select class="w-full text-sm border-slate-300 rounded-md p-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="department">
                    <option selected>---- SELECT DEPARTMENT ----</option>
                    @foreach($department as $departments)
                    <option value="{{$departments->department_name}}">{{$departments->department_name}} - {{$departments->department_code}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Employee ID</label>
                <select class="w-full text-sm border-slate-300 rounded-md p-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="employee">
                </select>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 px-4 py-2 border-b border-slate-200 flex justify-between items-center">
        <h3 class="text-sm font-semibold text-slate-700">Employee's Pay and Contributions</h3>
        <div class="flex space-x-2">
            <button type="button" id="Recompute" class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded flex items-center transition-colors">
                <i class="fa fa-calculator mr-1"></i> Recompute
            </button>
            <button type="button" id="updateData" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded flex items-center transition-colors">
                <i class="fa fa-save mr-1"></i> Save
            </button>
        </div>
    </div>
    <div class="p-4">
        <form id="editForm">
            <input type="hidden" name="employee_id" id="employee_id">
            <input type="hidden" name="date_from" id="date_from">
            <input type="hidden" name="date_to" id="date_to">
            <input type="hidden" name="endMonth" id="endMonth">
            <input type="hidden" name="payroll_no" id="payroll_no">
            <input type="hidden" name="payroll_id" id="payroll_id">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider border-b border-slate-100 pb-1 mb-2">Earnings (Hours & Amounts)</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Field Template -->
                            @php
                                $earningsFields = [
                                    ['label' => 'Work days', 'id' => 'WD', 'ph' => 'Days'],
                                    ['label' => 'Overtime', 'id' => 'OT', 'ph' => 'Hrs'],
                                    ['label' => 'Ext.Reg(Hrs)', 'id' => 'ER', 'ph' => 'Hrs'],
                                    ['label' => 'Night Diff(hrs)', 'id' => 'ND', 'ph' => 'Hrs'],
                                    ['label' => 'Rest Day(hrs)', 'id' => 'RS', 'ph' => 'Hrs'],
                                    ['label' => 'Rest Day(ehrs)', 'id' => 'ERS', 'ph' => 'EHrs'],
                                    ['label' => 'Reg Holiday(hrs)', 'id' => 'RH', 'ph' => 'Hrs'],
                                    ['label' => 'Reg Holiday(ehrs)', 'id' => 'ERH', 'ph' => 'EHrs'],
                                    ['label' => 'RD on Reg(hrs)', 'id' => 'RDR', 'ph' => 'Hrs'],
                                    ['label' => 'RD on Reg(ehrs)', 'id' => 'ERDR', 'ph' => 'EHrs'],
                                    ['label' => 'RD on Spl(hrs)', 'id' => 'RDS', 'ph' => 'Hrs'],
                                    ['label' => 'RD on Spl(ehrs)', 'id' => 'ERDS', 'ph' => 'EHrs']
                                ];
                            @endphp
                            
                            @foreach($earningsFields as $field)
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5 truncate" title="{{$field['label']}}">{{$field['label']}}</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="input{{$field['id']}}" name="input{{$field['id']}}" placeholder="{{$field['ph']}}">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="input{{$field['id']}}_amount" name="input{{$field['id']}}_amount" placeholder="Amt">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-red-500 uppercase tracking-wider border-b border-slate-100 pb-1 mb-2">Debit / Credit</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Absent(days)</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputAbsent" name="inputAbsent" placeholder="Days">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputAbsent_amount" name="inputAbsent_amount" placeholder="Amt">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Undertime(hrs)</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputUT" name="inputUT" placeholder="Hrs">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputUT_amount" name="inputUT_amount" placeholder="Amt">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Reg Holiday(days)</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCRH" name="inputCRH" placeholder="Days">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCRH_amount" name="inputCRH_amount" placeholder="Amt">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Spl Holiday(days)</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCSH" name="inputCSH" placeholder="Days">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCSH_amount" name="inputCSH_amount" placeholder="Amt">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-green-600 uppercase tracking-wider border-b border-slate-100 pb-1 mb-2 mt-4">Leaves & Other Pay</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Vacation Leave</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputIL" name="inputIL" placeholder="Days">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputIL_amount" name="inputIL_amount" placeholder="Amt">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Sick Leave</label>
                                <div class="flex space-x-1">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputSL" name="inputSL" placeholder="Days">
                                    <input type="number" class="w-1/2 px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputSL_amount" name="inputSL_amount" placeholder="Amt">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Other NT Pay</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputNTP_amount" name="inputNTP_amount" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Other Pay</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputOther_amount" name="inputOther_amount" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">13th Month</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="input13M_amount" name="input13M_amount" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Cola</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCola_amount" name="inputCola_amount" placeholder="Amount">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-orange-500 uppercase tracking-wider border-b border-slate-100 pb-1 mb-2">Contributions & Loans</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Witholding Tax</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputWT_amount" name="inputWT_amount" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">SSS Contrib</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputSSS_contrib" name="inputSSS_contrib" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">PHIC Contrib</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputPHIC_contrib" name="inputPHIC_contrib" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">HDMF Contrib</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputHDMF_contrib" name="inputHDMF_contrib" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Insurance</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputInsurance" name="inputInsurance" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">SSS Loan</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputSSS_loan" name="inputSSS_loan" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Pag-IBIG Loan</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputHDMF_loan" name="inputHDMF_loan" placeholder="Amount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Coop Loan</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputCoop_loan" name="inputCoop_loan" placeholder="Amount">
                            </div>
                            <div class="flex flex-col col-span-2">
                                <label class="text-[10px] uppercase font-bold text-slate-500 mb-0.5">Other Loans</label>
                                <input type="number" class="w-full px-1.5 py-1 text-xs border border-slate-300 rounded shadow-sm" id="inputOther_loan" name="inputOther_loan" placeholder="Amount">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 p-3 rounded border border-slate-200 mt-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-600 mb-1">Excess Hours</label>
                                <input type="number" class="w-full px-2 py-1.5 text-sm font-medium border border-slate-300 rounded shadow-sm bg-gray-100" id="inputEH_amount" name="inputEH_amount" disabled>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-600 mb-1">Gross Pay</label>
                                <input type="number" class="w-full px-2 py-1.5 text-sm font-medium border border-slate-300 rounded shadow-sm bg-gray-100 text-blue-700" id="inputGP_amount" name="inputGP_amount" disabled>
                            </div>
                            <div class="flex flex-col col-span-2">
                                <label class="text-sm font-bold text-slate-800 mb-1 border-t border-slate-200 pt-2">Net Pay</label>
                                <input type="number" class="w-full px-2 py-2 text-base font-bold border border-green-300 rounded shadow-sm bg-green-50 text-green-700" id="inputNP_amount" name="inputNP_amount" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
>>>>>>> branch1
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/edit/edit.js"></script>