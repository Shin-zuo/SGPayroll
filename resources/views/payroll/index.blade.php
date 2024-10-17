@extends('layouts.app')
@section('content')
    @if($employee->count()!=0)
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="text-center"><strong>{{$employee->first()->department}}</strong></h3></div>
    <input type="hidden" id="payrollType" value="{{$employee->first()->payroll_type}}">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <form class="form-horizontal" action="/payroll" method="get">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="hidden" id="employeePayroll_type" name="employeePayroll_type" value="{{$employee->first()->payroll_type}}">
                        <input type="hidden" id="deptCode" name="deptCode" value="{{$employee->first()->department}}">
                        <label for="payNo" class="col-md-2 control-label">Payroll No.</label>

                        <div class="col-md-1">
                          @if($employee->first()->payroll_type==1 || $employee->first()->payroll_type==2)
                            <select class="form-control" id="payroll_no" name="payroll_no">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                          @elseif($employee->first()->payroll_type==3 || $employee->first()->payroll_type==4)
                            <select class="form-control" id="payroll_no" name="payroll_no">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                          @endif
                        </div>
                        <label for="periodFrom" class="col-md-2 control-label">Payroll period from: </label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="date_from" name="date_from">
                        </div>
                        <label class="col-md-1 label-center control-label">to</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="date_to" name="date_to" >
                        </div>
                    </div>
                </form>


           </div>
            <div class="col-md-12">
                 <div class="col-md-2 pull-right">
                    <div class="row">
                     <button type="button" id="insertFinishData" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-save"></i> Save Data</button>
                     </div>
                </div>
                <div class="col-md-6 pull-right">
                    <div class="well well-sm row">
                        <div class="col-md-6">
                            <div class="form-check control-label">
                                <input class="form-check-input" type="checkbox" value="1" id="13Month" name="13Month">
                                <label class="form-check-label" for="13Month">
                                    Compute 13th month
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check control-label">
                                <input class="form-check-input" type="checkbox" value="1" id="endMonth" name="endMonth">
                                <label class="form-check-label" for="endMonth">
                                    End of Month
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
   </div>
</div>
@endif
@foreach($employee as $employees)
<form id="payrollCompute">
    {{csrf_field()}}
    <div class="panel panel-primary payroll-table-main">
        <input type="hidden" id="employee" name="employee" value="{{$employees->id}}">
        <input type="hidden" id="deptName" name="deptName" value="{{$employees->department}}">
        <div class="panel-heading">
            {{--<button type="button" class="btn btn-warning pull-right" data-toggle="modal" data-target="#exampleModal3">--}}
                {{--Edit--}}
            {{--</button>--}}
            <h4 class="text-center"><strong><i class="fa fa-user"></i>  {{$employees->full_name}}</strong></h4>
            {{--<button class="btn btn-default" id="hideSubmit" name="hideSubmit">Submit</button>--}}

        </div>
        <div class="panel-body">
            <table class="table payroll-table">
                <thead>
                    <tr class="info">
                        <th colspan="12">Basic Pay</th>

                    </tr>
                    <tr  class="info">
                        <th>WorkDay(days)</th>
                        <th>OT(hrs)</th>
                        <th>Ext.Reg(Hrs)</th>
                        <th>Night Diff(hrs)</th>
                        <th>Rest Day(hrs)</th>
                        <th>Rest Day(ehrs)</th>
                        <th>Regular Holiday(hrs)</th>
                        <th>Regular Holiday(ehrs)</th>
                        <th>Rest Day on Regular(hrs)</th>
                        <th>Rest Day on Regular(ehrs)</th>
                        <th>Rest Day on Special(hrs)</th>
                        <th>Rest Day on Special(ehrs)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="number" class="form-control input-sm" id="work_days" name="work_days"></td>
                        <td><input type="number" class="form-control input-sm" id="overtime_hours" name="overtime_hours"></td>
                        <td><input type="number" class="form-control input-sm" id="extra_regular_hour" name="extra_regular_hour"></td>
                        <td><input type="number" class="form-control input-sm" id="night_diff" name="night_diff"></td>
                        <td><input type="number" class="form-control input-sm" id="rest_special" name="rest_special"></td>
                        <td><input type="number" class="form-control input-sm" id="rest_special_exc" name="rest_special_exc"></td>
                        <td><input type="number" class="form-control input-sm" id="regular_holiday_hour" name="regular_holiday_hour"></td>
                        <td><input type="number" class="form-control input-sm" id="regular_holiday_hour_exc" name="regular_holiday_hour_exc"></td>
                        <td><input type="number" class="form-control input-sm" id="restday_on_regular" name="restday_on_regular"></td>
                        <td><input type="number" class="form-control input-sm" id="restday_on_regular_exc" name="restday_on_regular_exc"></td>
                        <td><input type="number" class="form-control input-sm" id="restday_on_special" name="restday_on_special"></td>
                        <td><input type="number" class="form-control input-sm" id="restday_on_special_exc" name="restday_on_special_exc"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table payroll-table">
                <thead>
                    <tr>
                        <th colspan="2" class="info">Debit</th>
                        <th colspan="4" class="warning">Credit</th>
                        <th colspan="2" class="danger">Non-Taxable Benefits</th>
                        <th colspan="2" class="success">Non-Taxable Other Pay</th>
                        <th rowspan="2" class="active">Excess Hours</th>
                        <th rowspan="2" class="active">Gross Pay</th>
                    </tr>
                    <tr>
                        <th class="info">Absent(days)</th>
                        <th class="info">Undertime(hrs)</th>
                        <th class="warning">Regular Holiday(days)</th>
                        <th class="warning">Special Holiday(days)</th>
                        <th class="warning">Regular Holiday(Minimum)</th>
                        <th class="warning">Special Holiday(Minimum)</th>
                        <th class="danger">Vacation Leave(days)</th>
                        <th class="danger">Sick Leave(days)</th>
                        <th class="success">Other Nt Pay</th>
                        <th class="success">13th month pay</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="number" class="form-control input-sm" id="absent" name="absent"></td>
                        <td><input type="number" class="form-control input-sm" id="underTime" name="underTime"></td>
                        <td><input type="number" class="form-control input-sm" id="regular_holiday" name="regular_holiday"></td>
                        <td><input type="number" class="form-control input-sm" id="special_holiday" name="special_holiday"></td>
                        <td><input type="number" class="form-control input-sm" id="regular_holiday_minimum" name="regular_holiday_minimum"></td>
                        <td><input type="number" class="form-control input-sm" id="special_holiday_minimum" name="special_holiday_minimum"></td>
                        <td><input type="number" class="form-control input-sm" id="sick_leave" name="sick_leave"></td>
                        <td><input type="number" class="form-control input-sm" id="vacation_leave" name="vacation_leave"></td>
                        <td><input type="number" class="form-control input-sm" id="other_pay" name="other_pay"></td>
                        <td><input type="number" class="form-control input-sm" id="thirteen_month" name="thirteen_month"></td>
                        <td><input type="number" class="form-control input-sm" id="excess_amount" name="excess_amount" disabled></td>
                        <td><input type="number" class="form-control input-sm" id="gross_pay" name="gross_pay" disabled></td>
                    </tr>
                </tbody>
            </table>
            <table class="table payroll-table">
                <thead>
                    <tr class="secondary">
                        <th colspan="4" class="danger">Contributions</th>
                        <th colspan="7" class="warning">Loans</th>
                        <th rowspan="2" class="active">Net Pay</th>
                    </tr>
                    <tr>
                        <th class="danger">Witholding Tax</th>
                        <th class="danger">SSS</th>
                        <th class="danger">PHIC</th>
                        <th class="danger">HDMF</th>
                        <th class="warning">Insurance</th>
                        <th class="warning">SSS</th>
                        <th class="warning">Calamity</th>
                        <th class="warning">Pag-IBIG</th>
                        <th class="warning">Advancement</th>
                        <th class="warning">Coop</th>
                        <th class="warning">Others</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td name="witholding_tax">0.00</td>
                        <td name="sss_deduction">0.00</td>
                        <td name="phil_deduction">0.00</td>
                        <td name="pagibig_deduction">0.00</td>
                        <td name="insurance">0.00</td>
                        <td name="sss_loan">0.00</td>
                        <td name="calamity_loan">0.00</td>
                        <td name="hdmf_loan">0.00</td>
                        <td name="company_loan">0.00</td>
                        <td name="other_loan">0.00</td>
                        <td name="rent_other">0.00</td>
                        <td name="net_pay">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <td><input type="hidden" class="form-control input-sm" id="nt_pay" name="nt_pay"></td>
        <input type="hidden" id="basic_amount" name="basic_amount" value="">
        <input type="hidden" id="work_days_amount" name="work_days_amount" value="">
        <input type="hidden" id="over_time_amount" name="over_time_amount" value="">
        <input type="hidden" id="extra_regular_hours_amount" name="extra_regular_hours_amount" value="">
        <input type="hidden" id="night_diff_amount" name="night_diff_amount" value="">
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
        <input type="hidden" id="cola" name="cola" value="">
        <input type="hidden" id="other_loan_total" name="other_loan_total" value="">
        <input type="hidden" id="net_pay_total" name="net_pay_total" value="">
        <input type="hidden" id="regular_holiday_amount" name="regular_holiday_amount" value="">
        <input type="hidden" id="special_holiday_amount" name="special_holiday_amount" value="">
        <input type="hidden" id="regular_holiday_minimum_amount" name="regular_holiday_minimum_amount" value="">
        <input type="hidden" id="special_holiday_minimum_amount" name="special_holiday_minimum_amount" value="">
    </div>
</form>

<!-- edit modal -->
<!-- <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModal3Label">Employee Name</h5>
            </div>
            <div class="modal-body">
                <label class="legend-label">Employee's Pay and Contributions</label> 
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">Basic Pay</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">Gross Pay</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">Net Pay</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                        </form>
                        <label class="legend-label">Basis</label> 
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">SSS</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">WTax</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-5 control-label">HDMF</label>
                                <div class="col-sm-7">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <p class="form-control-static"></p>
                                </div>
                                <label class="col-sm-5 legend-label">Employer's Contribution</label>
                                <label class="col-sm-5 legend-label">Employee's Contribution</label>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">HDMF</label>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">EC</label>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                                <div class="col-sm-5">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">HDMF</label>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">Union</label>
                                <div class="col-sm-5">

                                </div>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">WTax</label>
                                <div class="col-sm-5">

                                </div>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBP" class="col-sm-2 control-label">PHC</label>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" class="input-sm form-control" id="inputBP">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form>
                            <label class="legend-label">Taxable Compensation income</label>
                            <div class="form-group">
                                <label for="input13">13th Month Pay and Other Benefits</label>
                                <input type="number" class="form-control input-sm" id="input13">
                            </div>
                        </form>
                        <hr>
                        <form>
                            <label class="legend-label">Non-Taxable Compensation income</label>
                            <div class="form-group">
                                <label for="input13">13th Month Pay and Other Benefits</label>
                                <input type="number" class="form-control input-sm" id="input13">
                            </div>
                            <div class="form-group">
                                <label for="input13">Salaries and Other Forms of Compenstation</label>
                                <input type="number" class="form-control input-sm" id="input13">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <h5 class="modal-title" id="exampleModalLabel">Specific Pay Group and Period</h5>        
          </div>
          <div class="modal-body">
            <h5>Payroll Period</h5>
            <hr class="hr-em">
            <form>
                <div class="form-group col-md-4">
                    <label>Pay Group :</label>
                    <select id="" class="form-control">
                        <option value="" selected>SDC</option>
                        <option value="1">WL</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="formGroupExampleInput2">Payroll Period</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="formGroupExampleInput2">Payroll No.</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
                </div>
            </form>
            <form>
              <div class="form-group col-md-4">
                <label for="formGroupExampleInput">Month :</label>
                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
            </div>
            <div class="form-group col-md-4">
                <label for="formGroupExampleInput2">Year :</label>
                <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
            </div>
            <div class="form-group col-md-4">
                <label for="formGroupExampleInput2">Period Type</label>
                <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
            </div>
        </form>

        <div class="form-check text-center">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1">
            Check if end of the month
        </label>
    </div>
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Pay Group :</label>
            <div class="col-md-9">
                <input type="text" class="form-control">
            </div>
        </div>
    </form>
    <h5>Cut-off Date</h5>
    <hr class="hr-em">
    <form class="form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <input type="date" class="form-control">
            </div>
            <label class="col-md-1 control-label">to</label>
            <div class="col-md-5">
                <input type="date" class="form-control">
            </div>
        </div>
    </form>
    <h5>Last Period</h5>
    <hr class="hr-em">
    <input type="date" class="form-control">
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>
@endforeach
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/payroll/payrollComputation.js"></script>