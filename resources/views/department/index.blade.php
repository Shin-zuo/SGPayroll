@extends('layouts.app')
@section('content')
    
<<<<<<< HEAD
    <div class="panel panel-default" style="background-color:#f7e8f0">
        <div class="panel-heading text-center" style="background-color:#f1c6de"><h1><strong>Group</strong></h1></div>
        <div class="panel-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addDepartmentModal" title="View" data-content="" >
                <span class="glyphicon glyphicon-plus"></span>
                Add Group
            </button>
            <hr>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Group Code</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($department as $departments)
                        <tr>
                            <td><strong>{{strtoupper($departments->department_name)}}</strong></td>
                            <td><strong>{{$departments->department_code}}</strong></td>
                            <td>
                                    <a href="/department/{{$departments->id}}" class="btn btn-sm btn-primary"  >
                                        <i class="fas fa-plus"></i>
                                      Add SubGroup
                                    </a>
                                <a href="/payroll/{{$departments->department_name}}" class="btn btn-sm btn-success"  >
                                    <i class="fas fa-calculator"></i>
                                    Payroll
                                </a>
                                {{--<a href="/thirteen-month/{{$departments->department_code}}" class="btn btn-sm btn-success"  >--}}
                                    {{--<i class="fas fa-calculator"></i>--}}
                                    {{--13 Month Pay--}}
                                {{--</a>--}}
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editDepartmentModal" data-zip="{{$departments->zip_code}}" data-telno="{{$departments->tel_no}}" data-code="{{$departments->department_code}}" data-tin="{{$departments->employer_tin}}" data-sss="{{$departments->employer_sss}}" data-address="{{$departments->department_address}}" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}">
                                    <i class="glyphicon glyphicon-cog"></i>
                                    Edit
                                </button>
                                {{--<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#periodModal" data-id="{{$departments->id}}">--}}
                                    {{--<i class="glyphicon glyphicon-cog"></i>--}}
                                        {{--Period--}}
                                {{--</button>--}}
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

=======
<div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Groups</h1>
        <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="flex space-x-2">
                <li><a href="#" class="hover:text-slate-800 transition-colors">Home</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800">Groups</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden mb-8">
        <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-base font-semibold text-slate-800">Manage Groups</h2>
            <button type="button" class="bg-slate-800 text-white hover:bg-slate-700 px-3 py-1.5 rounded-md text-xs transition-colors" data-toggle="modal" data-target="#addDepartmentModal" title="View" data-content="" >
                <i class="fas fa-plus mr-1"></i> Add Group
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2 border-b border-slate-200">Group Name</th>
                    <th class="px-4 py-2 border-b border-slate-200">Group Code</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @foreach($department as $departments)
                    <tr class="hover:bg-slate-50 transition-colors bg-white">
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-800">{{strtoupper($departments->department_name)}}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$departments->department_code}}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-right text-xs font-medium">
                            <a href="/department/{{$departments->id}}" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded transition-colors mr-1">
                                Add SubGroup
                            </a>
                            <a href="/payroll/{{$departments->department_name}}" target="_blank" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded transition-colors mr-1">
                                Payroll
                            </a>
                            <button type="button" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded transition-colors mr-1" data-toggle="modal" data-target="#editDepartmentModal" data-zip="{{$departments->zip_code}}" data-telno="{{$departments->tel_no}}" data-code="{{$departments->department_code}}" data-tin="{{$departments->employer_tin}}" data-sss="{{$departments->employer_sss}}" data-address="{{$departments->department_address}}" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}">
                                Edit
                            </button>
                            <button type="button" class="btn-delete-group text-red-600 hover:bg-red-50 px-2 py-1 rounded transition-colors" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
>>>>>>> branch1
    </div>
    
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Add Group</h4>
                </div>
                <div class="modal-body">
                    <form id="addDepartment" name="addDepartment" class="form-horizontal" novalidate="">
                        <div class="form-group">
                            <label for="inputDepartmenCode" class="col-sm-3 control-label " >Group Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-capitalize" id="group_name" name="group_name">
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="inputDepartmenName" class="col-sm-3 control-label " >Group Code :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control  has-error text-capitalize" id="group_code" name="group_code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmployerTin" class="col-sm-3 control-label " >Employer Tin# :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="employer_tin" name="employer_tin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmployerNo" class="col-sm-3 control-label " >Employer No# :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="employer_sss" name="employer_sss">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmployerTelNo" class="col-sm-3 control-label " >Tel. No# :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="employer_telNo" name="employer_TelNo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="group_address" name="group_address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmployerZip" class="col-sm-3 control-label " >Zip Code :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="employer_zip" name="employer_zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payroll_type" class="col-sm-3 control-label " >Payroll Type :</label>
                            <div class="col-sm-9">
                                <select id="payroll_type" class="form-control" name="payroll_type">
                                    <option value="1">MONTHLY</option>
                                    <option value="2">SEMI-MONTHLY</option>
                                    <option value="3">WEEKLY</option>
                                    <option value="4">DAILY</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_addGroup">Add Group</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Edit Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addDepartment" name="addDepartment" class="form-horizontal" novalidate="">
                        <div class="form-group">
                            <label for="inputDepartmenCode" class="col-sm-3 control-label " >Group Name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-capitalize" id="edit_group_name" name="edit_group_name">
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="inputDepartmenName" class="col-sm-3 control-label " >Group Code :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control  has-error text-capitalize" id="edit_group_code" name="edit_group_code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEditEmployerTin" class="col-sm-3 control-label " >Employer Tin# :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-capitalize" id="edit_employer_tin" name="edit_employer_tin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEditEmployerNo" class="col-sm-3 control-label " >Employer No# :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control text-capitalize" id="edit_employer_sss" name="edit_employer_sss">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEditEmployerTelNo" class="col-sm-3 control-label " >Tel. No# :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="edit_employer_telNo" name="edit_employer_TelNo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="edit_group_address" name="edit_group_address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEditEmployerZip" class="col-sm-3 control-label " >Zip Code :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control text-capitalize" id="edit_employer_zip" name="edit_employer_zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_payroll_type" class="col-sm-3 control-label " >Payroll Type :</label>
                            <div class="col-sm-9">
                                <select id="edit_payroll_type" class="form-control" name="edit_payroll_type">
                                    <option value="1">MONTHLY</option>
                                    <option value="2">SEMI-MONTHLY</option>
                                    <option value="3">WEEKLY</option>
                                    <option value="4">DAILY</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <h4 class="modal-title text-center" id="exampleModalLabel">13 Month</h4>
                        <div class="form-group">
                            <label for="inputEditEmployerZip" class="col-sm-3 control-label " >From :</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="edit_13monthFrom" id="edit_13monthFrom" value="{{date('Y-m')}}">
                            </div>
                        </div>   <div class="form-group">
                            <label for="inputEditEmployerZip" class="col-sm-3 control-label " >To :</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="edit_13monthTo" id="edit_13monthTo" value="{{date('Y-m')}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editNameGroup">Edit Group</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Modal -->
<div class="modal fade" id="periodModal" tabindex="-1" role="dialog" aria-labelledby="periodModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h5 class="modal-title" id="periodModalLabel">Period Period</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="periodFrom" class="col-md-3 control-label"> from: </label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="date_from" name="date_from">
                            </div>
                            <label class="col-md-1 label-center control-label">to</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="date_to" name="date_to" >
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePeriod">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/department/department.js"></script>