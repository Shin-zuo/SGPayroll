@extends('layouts.app')
@section('content')
    
    <div class="panel panel-default">
        <div class="panel-heading">Employee</div>
        <div class="panel-body">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#paymentModal" title="View" >
                <span class="glyphicon glyphicon-plus"></span>
                Add Employee
            </button>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Date Hired</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>

    </div>
    
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Add Employee</h4>
                </div>
                <div class="modal-body">
                    <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                        <div class="form-group error">
                            <label for="inputLastName" class="col-sm-3 control-label">Last Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control has-error" id="last_name" name="last_name" >
                            </div>
                        </div>

                        <div class="form-group error">
                            <label for="inputFirstName" class="col-sm-3 control-label">First Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control has-error" id="first_name" name="first_name"  value="">
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="inputMidName" class="col-sm-3 control-label">Middle Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control has-error" id="mid_name" name="mid_name"  value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputGender" class="col-sm-3 control-label">Gender :</label>
                            <div class="col-sm-9">
                                <select id="gender" class="form-control" name="gender" >
                                    <option value="" selected>Select Category</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="inputDateHired" class="col-sm-3 control-label">Date Hired :</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control has-error" id="date_hired" name="date_hired"  value="">
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="inputBirthDate" class="col-sm-3 control-label">Date of Birth :</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control has-error" id="birth_date" name="birth_date"  value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDepartment" class="col-sm-3 control-label">Department :</label>
                            <div class="col-sm-9">
                                <select id="department" class="form-control" name="department" >
                                    <option value="" selected>Select Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPosition" class="col-sm-3 control-label">Position :</label>
                            <div class="col-sm-9">
                                <select id="position" class="form-control" name="position" >
                                    <option value="" selected>Select Position</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" >Submit</button>
                    <button type="button" class="btn btn-danger" id="btn-danger" >Clear Fields</button>
                </div>
            </div>
        </div>
    </div>
@endsection
