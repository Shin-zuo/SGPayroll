@extends('layouts.app')
@section('content')
<<<<<<< HEAD
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
=======
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Inactive Employees</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Inactive Employees</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-base font-semibold text-slate-800">Inactive Employee Directory</h2>
        <a href="{{ route('employee') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fa fa-arrow-left mr-1.5"></i> Back to Active
        </a>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="emptable" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2 border-b border-slate-200">ID</th>
                    <th class="px-4 py-2 border-b border-slate-200">Name</th>
                    <th class="px-4 py-2 border-b border-slate-200">Department</th>
                    <th class="px-4 py-2 border-b border-slate-200">Position</th>
                    <th class="px-4 py-2 border-b border-slate-200">Date Hired</th>
                    <th class="px-4 py-2 border-b border-slate-200">Gender</th>
                    <th class="px-4 py-2 border-b border-slate-200">Status</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($inactive_employee as $employees)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->id}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-800">{{strtoupper($employees->full_name)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{strtoupper($employees->department)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->position}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->date_hired}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->gender}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/employee/account/{{$employees->id}}" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank" title="View Account">
                            <i class="fa fa-user-edit"></i>
                        </a>
                        <a href="#" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="text-green-600 hover:text-green-900" title="Set Active">
                            <i class="fa fa-user-check"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <p class="text-sm text-slate-600">Turn this employee to active?</p>
>>>>>>> branch1
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
<<<<<<< HEAD
                <button type="button" class="btn btn-primary"  id="btnYesActive">Yes</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">No</button>
=======
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="btnYesActive">Yes</button>
>>>>>>> branch1
            </div>
        </div>
    </div>
</div>
@endsection
<<<<<<< HEAD
=======

>>>>>>> branch1
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/employee.js"></script>
<script>
    $(document).ready(function() {
        $('#emptable').DataTable();
<<<<<<< HEAD
    } );
=======
    });
>>>>>>> branch1
</script>
