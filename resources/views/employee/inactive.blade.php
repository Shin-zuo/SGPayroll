@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="panel panel-default" style="background-color:#f7e8f0">
        <div class="panel-heading" style="background-color:#f1c6de"><h1 class="text-center"><strong> Inactive Employee</strong></h1></div>
        <div class="panel-body">
            <div class="row">
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
                @foreach($inactive_employee as $employees)
                    <tr>
                        <td>{{$employees->id}}</td>
                        <td><strong>{{strtoupper($employees->full_name)}}</strong></td>
                        <td>{{strtoupper($employees->department)}}</td>
                        <td>{{$employees->position}}</td>
                        <td>{{$employees->date_hired}}</td>
                        <td>{{$employees->gender}}</td>
                        <td>{{$employees->status}}</td>
                        <td>
                            <a href="/employee/account/{{$employees->id}}" class="btn btn-sm btn-primary"  >
                                <i class="glyphicon glyphicon-pencil"></i>
                                Account
                            </a>
                            <a href="#" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="btn btn-danger">Active</a>

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
                    <p>Turn this employee to active ?</p>
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="btnYesActive">Yes</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">No</button>
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
