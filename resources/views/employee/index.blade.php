@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="panel panel-default" style="background-color:#f7e8f0">
        <div class="panel-heading" style="background-color:#f1c6de"><h1 class="text-center"><strong>Employee</strong></h1></div>
        <div class="panel-body">
            <div class="row">
                <form>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEmployee" title="View" data-content="" >
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            Add Employee
                        </button>
                    </div>
                </form>
            </div>
            <hr>
            <table id="emptable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Date Hired</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee as $employees)
                    <tr>
                        <td>{{$employees->id}}</td>
                        <td><strong>{{strtoupper($employees->full_name)}}</strong></td>
                        <td>{{strtoupper($employees->department)}}</td>
                        <td>{{$employees->position}}</td>
                        <td>{{$employees->date_hired}}</td>
                        <td>{{$employees->gender}}</td>
                        <td>{{$employees->status}}</td>
                        <td>
                            <a href="/employee/account/{{$employees->id}}" class="btn btn-sm btn-primary"  target="_blank">
                                <i class="glyphicon glyphicon-pencil"></i>
                                Account
                            </a>
                            <a href="#" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="btn btn-danger">Inactive</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            
        </div>

    </div>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form>
                    <p>Turn this employee to Inactive ?</p>
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="btnYes">Yes</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Add Employee</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                            <div class="form-group error">
                                <label for="inputSSS" class="col-sm-4 control-label">Employee ID :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="employee_id" name="employee_id" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputLastName" class="col-sm-4 control-label">Last Name :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="last_name" name="last_name">
                                </div>
                            </div>

                            <div class="form-group error">
                                <label for="inputFirstName" class="col-sm-4 control-label">First Name :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="first_name" name="first_name" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputMidName" class="col-sm-4 control-label">Middle Name :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="mid_name" name="mid_name" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputGender" class="col-sm-4 control-label">Gender :</label>
                                <div class="col-sm-8">
                                    <select id="gender" class="form-control" name="gender" >
                                        <option value="" selected>Select Category</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputStatus" class="col-sm-4 control-label">Status :</label>
                                <div class="col-sm-8">
                                    <select id="status" class="form-control" name="status" >
                                        <option value="" selected>Select Status</option>
                                        <option value="Single" >Single</option>
                                        <option value="Married" >Married</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputDateHired" class="col-sm-4 control-label">Date Hired :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control has-error" id="date_hired" name="date_hired"  value="">
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputBirthDate" class="col-sm-4 control-label">Date of Birth :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control has-error" id="birth_date" name="birth_date"  value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDepartment" class="col-sm-4 control-label">Group :</label>
                                <div class="col-sm-8">
                                    <select id="department" class="form-control" name="department" >
                                        <option value="" selected>Select Department</option>
                                        @foreach($department as $departments)
                                        <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSubDepartment" class="col-sm-4 control-label">SubGroup :</label>
                                <div class="col-sm-8">
                                    <select id="sub_department" class="form-control" name="sub_department" >
                                        <option value="" selected>Select Sub Department</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputAddress" class="col-sm-4 control-label">Address :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="address" name="address" >
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">


                            <div class="form-group error">
                                <label for="inputSSS" class="col-sm-4 control-label">SSS no. :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="sss_no" name="sss_no" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputPhilhealth" class="col-sm-4 control-label">Phil. Health :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="phil_health" name="phil_health" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputTin" class="col-sm-4 control-label">TIN no. :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="tin" name="tin" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputTin" class="col-sm-4 control-label">Pag-IBIG no. :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="hdmf" name="hdmf" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputTin" class="col-sm-4 control-label">UCPB no. :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="ucpb" name="ucpb" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputTin" class="col-sm-4 control-label">Passport no. :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="passport_no" name="passport_no" >
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputTin" class="col-sm-4 control-label">Passport exp :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control  has-error" id="passport_exp" name="passport_exp" >
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="btn-submit" >Submit</button>
                                <button type="button" class="btn btn-danger" id="btn-danger" >Clear Fields</button>
                            </div>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/employee.js"></script>
<script>
    $(document).ready(function() {
        $('#emptable').DataTable();
    } );
</script>
