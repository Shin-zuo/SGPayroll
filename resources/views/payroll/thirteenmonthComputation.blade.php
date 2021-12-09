@extends('layouts.app')
@section('content')
    @if($employee->count()!=0)
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="text-center"><strong>{{$employee->first()->departments->department_name}}</strong></h3></div>
            <input type="hidden" id="payrollType" value="{{$employee->first()->payroll_type}}">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="/payroll" method="get">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" id="employeePayroll_type" name="employeePayroll_type" value="{{$employee->first()->payroll_type}}">
                                <input type="hidden" id="deptCode" name="deptCode" value="{{$employee->first()->department}}">
                                <label for="periodFrom" class="col-md-2 control-label">Payroll period from: </label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                                <label class="col-md-1 label-center control-label">to</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="date_to" name="date_to" >
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="insertFinishData" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-save"></i> Save Data</button>
                                </div>
                            </div>
                        </form>


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
                            <th colspan="12">Monthly Gross</th>

                        </tr>
                        <tr  class="info">
                            <th>JANUARY</th>
                            <th>FEBRUARY</th>
                            <th>MARCH</th>
                            <th>APRIL</th>
                            <th>MAY</th>
                            <th>JUNE</th>
                            <th>JULY</th>
                            <th>AUGUST</th>
                            <th>SEPTEMBER</th>
                            <th>OCTOBER</th>
                            <th>NOVEMBER</th>
                            <th>DECEMBER</th>
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
                            <th colspan="2" class="warning">Credit</th>
                            <th colspan="1" class="danger">Non-Taxable Benefits</th>
                            <th colspan="3" class="success">Non-Taxable Other Pay</th>
                            <th rowspan="2" class="active">Excess Hours</th>
                            <th rowspan="2" class="active">Gross Pay</th>
                        </tr>
                        <tr>
                            <th class="info">Absent(days)</th>
                            <th class="info">Undertime(hrs)</th>
                            <th class="warning">Regular Holiday(days)</th>
                            <th class="warning">Special Holiday(days)</th>
                            <th class="danger">Incentive Leave(days)</th>
                            <th class="success">Other Nt Pay</th>
                            <th class="success">13th month pay</th>
                            <th class="success">Cola</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="number" class="form-control input-sm"></td>
                            <td><input type="number" class="form-control input-sm"></td>
                            <td><input type="number" class="form-control input-sm" id="regular_holiday" name="regular_holiday"></td>
                            <td><input type="number" class="form-control input-sm" id="special_holiday" name="special_holiday"></td>
                            <td><input type="number" class="form-control input-sm" id="sick_leave" name="sick_leave"></td>
                            <td><input type="number" class="form-control input-sm" id="other_pay" name="other_pay"></td>
                            <td><input type="number" class="form-control input-sm" id="thirteen_month" name="thirteen_month"></td>
                            <td><input type="number" class="form-control input-sm" id="cola" name="cola"></td>
                            <td><input type="number" class="form-control input-sm" id="excess_amount" name="excess_amount" disabled></td>
                            <td><input type="number" class="form-control input-sm" id="gross_pay" name="gross_pay" disabled></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </form>

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