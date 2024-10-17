@extends('layouts.app')
@section('content')

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12">
            <h3>Account</h3>
            <div class="form-check">
                @if($employee->categories=='true')
                    <input type="checkbox" class="form-check-input" id="categories" name="categories" checked>
                    <label class="form-check-label" for="categories">ADMIN</label>
                    @else
                    <input type="checkbox" class="form-check-input" id="categories" name="categories">
                    <label class="form-check-label" for="categories">ADMIN</label>
                    @endif
                @if($employee->salary_status=='true')
                    <input type="checkbox" class="form-check-input" id="salary_status" name="salary_status" checked>
                    <label class="form-check-label" for="categories">Minimum Wager</label>
                @else
                <input type="checkbox" class="form-check-input" id="salary_status" name="salary_status">
                    <label class="form-check-label" for="categories">Minimum Wager</label>
                @endif
            </div>
            <hr>
            @if(auth()->user()->user_type==1)
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#salaryModal" title="View" data-content="" >
                <i class="fa fa-plus" aria-hidden="true"></i>
                Rates
            </button>
            @endif
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deductionModal" title="View" data-content="" >
                <i class="fa fa-scissors" aria-hidden="true"></i>
                Deduction
            </button>
            <a href="/employee/account/{{$employee->id}}/loans" type="button" class="btn btn-danger" data-content="" >
                <i class="fa fa-scissors" aria-hidden="true"></i>
                Add Loan
            </a>
            <a href="/employee/account/{{$employee->id}}/other-computation" type="button" class="btn btn-warning" data-content="" >
                <i class="fa fa-scissors" aria-hidden="true"></i>
                Previous Information
            </a>
            <input type="hidden" name="id" id="id" value="{{$employee->id}}">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center"><strong>{{$employee->full_name}}</strong></h2>
                </div>
                <hr>
                <div class="col-md-12">
                    <h4 class="text-info account-label">
                        <strong> User Info </strong>
                    </h4>
                </div>
            </div>
            {{--<form>--}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fname">Firstname</label>
                            <input type="text" class="form-control" id="fname" value="{{$employee->employee_Fname}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mname">Middlename</label>
                            <input type="text" class="form-control" id="mname" value="{{$employee->employee_Mname}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lname">Lastname</label>
                            <input type="text" class="form-control" id="lname" value="{{$employee->employee_Lname}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Gender</label>
                            <select class="form-control" id="gender">
                                <option value="{{$employee->gender}}"> {{$employee->gender}}</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option>Single</option>
                                <option>Married</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" value="{{$employee->birth_day}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fname">Email</label>
                            <input type="email" class="form-control" id="email" value="{{$employee->email}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Address</label>
                            <textarea class="form-control" id="address" rows="2">{{$employee->address}}</textarea>
                        </div>
                    </div>

                </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-info account-label">
                        <strong> Contact person in case of emergency </strong>
                    </h4>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Contactname">Name</label>
                        <input type="text" class="form-control" id="Contactname" value="{{$employee->contactName}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ContactNo">Contact No.</label>
                        <input type="text" class="form-control" id="ContactNo" value="{{$employee->contactNo}}">
                    </div>
                </div>

                {{--<div class="col-md-4">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="lname">Contact person in case of emergency</label>--}}
                        {{--<input type="text" class="form-control" id="lname" value="{{$employee->employee_Lname}}">--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employmentStatus">Status of Employment</label>
                        <select class="form-control" id="employmentStatus">
                            <option value="" selected>{{$employee->employment_status}}  </option>
                            <option value="1">Regular</option>
                            <option value="2">Contractual</option>
                            <option value="3">Probationary</option>
                            <option value="4">Consultant & Senior Worker</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employment_date_from">Date from</label>
                        <input type="date" class="form-control" id="employment_date_from" value="{{$employee->employment_date_from}}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employment_date_to">Date to</label>
                        <input type="date" class="form-control" id="employment_date_to" value="{{$employee->employment_date_to}}" disabled>
                    </div>
                </div>

            </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employee">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" value="{{$employee->employee_id}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Date Hired</label>
                            <input type="date" class="form-control" id="date_hired" value="{{$employee->date_hired}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputDepartment" class="control-label">Group :</label>
                            <select id="department" class="form-control" name="department" >
                                <option value="{{$employee->department}}" selected>{{$employee->department}}</option>
                                @foreach($department as $departments)
                                <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputSubDepartment" class=" control-label">SubGroup :</label>
                            <select id="sub_department" class="form-control" name="sub_department" >
                                <option value="{{$employee->position}}" selected>{{$employee->position}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employee">SSS No.</label>
                            <input type="number" class="form-control" id="sss_no" value="{{$employee->sss_number}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employee">Phil. No.</label>
                            <input type="number" class="form-control" id="phil_health" value="{{$employee->philhealth_number}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employee">TIN No.</label>
                            <input type="number" class="form-control" id="tin" value="{{$employee->tin_number}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employee">Pag-IBIG No.</label>
                            <input type="number" class="form-control" id="hdmf" value="{{$employee->hdmf_number}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="employee">UCPB No.</label>
                            <input type="number" class="form-control" id="ucpb" value="{{$employee->ucpb_number}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="employee">Passport No.</label>
                            <input type="number" class="form-control" id="passport_no" value="{{$employee->passport_number}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="employee">Passport Exp.</label>
                            <input type="date" class="form-control" id="passport_exp" value="{{$employee->passport_exp}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button  class="btn btn-primary pull-right" name="updateAccount" id="updateAccount">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{--salary Modal--}}
<div class="modal fade" tabindex="-1" id="salaryModal" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title"><strong>Basic Pay</strong></h5>
            </div>
            <div class="modal-body">
                <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                    <input type="hidden" id="id" name="id" value="{{$employee->id}}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Payroll Type :</label>
                        <div class="col-sm-7">
                            <select id="payroll_type" class="form-control" name="payroll_type" >
                                @if($employee->payroll_type == 2)
                                    <option value="1" selected>SEMI-MONTHLY</option>
                                @elseif($employee->payroll_type == 1)
                                    <option value="2" selected>SEMI-MONTHLY</option>
                                @elseif($employee->payroll_type == 3)
                                    <option value="3" selected>WEEKLY</option>
                                @elseif($employee->payroll_type == 4)
                                    <option value="4" selected>DAILY</option>
                                @endif
                                <option value="2">MONTHLY</option>
                                <option value="1">SEMI-MONTHLY</option>
                                <option value="3">WEEKLY</option>
                                <option value="4">DAILY</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Basic Pay :</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control  has-error" id="basic_pay" name="basic_pay"  value="{{$employee->basic_pay}}">
                        </div>
                    </div>
                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Other NT Pay :</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control  has-error" id="other_nt_pay" name="other_nt_pay"  value="{{$employee->other_nt_pay}}">
                        </div>
                    </div>
                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Cola :</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control  has-error" id="cola" name="cola"  value="{{$employee->cola}}">
                        </div>
                    </div>
                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Vacation Leave :</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control  has-error" id="leave" name="leave"  value="{{$employee->leave}}">
                        </div>
                    </div>
                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Sick Leave :</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control  has-error" id="sick" name="sick"  value="{{$employee->sick_leave}}">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_updateSalary">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--deduction Modal--}}
<div class="modal fade bd-example-modal-sm" id="deductionModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Deduction</strong></h5>
            </div>
            <div class="modal-body">
                <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                    <input type="hidden" id="id_deduct" name="id_deduct" value="{{$employee->id}}">
                    <input type="hidden" id="tax" name="tax" value="{{$employee->tax_status}}">
                    <input type="hidden" id="phic_status" name="phic_status" value="{{$employee->phic_status}}">
                    <input type="hidden" id="sss_status" name="sss_status" value="{{$employee->sss_status}}">
                    <input type="hidden" id="pagibig" name="pagibig" value="{{$employee->pag_ibig_contribution}}">
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="tax_deduction" name="tax_deduction">
                            <label class="form-check-label" for="tax_deduction">
                                TAX
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="pagibig_deduction" name="pagibig_deduction">
                            <label class="form-check-label" for="pagibig_deduction">
                                Pag-IBIG
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="phil_deduction" name="phil_deduction">
                            <label class="form-check-label" for="phil_deduction">
                                PHIC
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="sss_deduction" name="sss_deduction">
                            <label class="form-check-label" for="sss_deduction">
                                SSS
                            </label>
                        </div>
                    </div>
                </form>

                <form>

                    <div class="form-group">
                        <label for="hdmf">HDMF</label>
                        <input type="number" class="form-control" id="pagibig_amount" name="pagibig_amount" value="{{$employee->pagibig_amount}}">
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="loan">Loan</label>--}}
                        {{--<input type="number" class="form-control" id="loan" name="loan" value="{{$employee->loan}}">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="union">Union</label>--}}
                        {{--<input type="number" class="form-control" id="union" name="union" value="{{$employee->union}}">--}}
                    {{--</div>--}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="deduction_btn">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--Computation--}}

<div class="modal fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center"><strong>Computation</strong></h5>
            </div>
            <div class="modal-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th class="text-center">Days/Hrs</th>
                      <th></th>
                      <th class="text-center">Amount</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Work Days</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>Day(s)</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
              <tr>
                  <th scope="row">Overtime</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>Hrs</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
              <tr>
                  <th scope="row">Ext. Regular Hours</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>Hrs</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
              <tr>
                  <th scope="row">Night Diff.</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>Hrs</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
              <tr>
                  <th scope="row">Rest/Special</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>Hrs</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
              <tr>
                  <th scope="row">Rest/Special</th>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
                  <td>EHrs</td>
                  <td><input type="number" class="form-control" id="formGroupExampleInput"></td>
              </tr>
          </tbody>
      </table>

  </div>
</div>
</div>
</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/employee.js"></script>

