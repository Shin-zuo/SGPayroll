@extends('layouts.app')
@section('content')
    
    <div class="panel panel-default">
        <div class="panel-heading">Group</div>
        <div class="panel-body">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addSubDepartmentModal" title="View" data-department_code="{{$department->department_code}}" >
                <span class="glyphicon glyphicon-plus"></span>
                Add SubGroup
            </button>
            <hr>
         <h4 class="text-center"><strong> {{$department->department_name}}</strong></h4>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <th>I.D</th>
                    <th>SubGroup Name</th>
                    <th>SubGroup Code</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($sub_department as $sub_departments)
                        <tr>
                            <td>{{$sub_departments->id}}</td>
                            <td>{{$sub_departments->sub_department_name}}</td>
                            <td>{{$sub_departments->department_code}}</td>
                            <td>

                                <button type="button" class="btn btn-sm btn-primary"  >
                                    <i class="glyphicon glyphicon-pencil"></i>
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Delete
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

    <div class="modal fade" id="addSubDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Add SubGroup</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addSubDepartment" name="addSubDepartment" class="form-horizontal" novalidate="">
                        <input type="hidden" name="generated_code" id="generated_code" value="{{$department->generated_code}}">
                        <div class="form-group error">
                            <label for="inputSubDepartmenName" class="col-sm-3 control-label " >SubGroup Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control  has-error text-capitalize" id="sub_group_name" name="sub_group_name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_addSubGroup">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/department/department.js"></script>