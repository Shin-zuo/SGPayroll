@extends('layouts.app')
@section('content')
<<<<<<< HEAD
    
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

=======
    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                <h4 class="text-lg font-bold text-[#192965] m-0">Employee</h4>
            </div>
            <div class="p-6">
                <button type="button" class="bg-[#192965] hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-2 mb-6" data-toggle="modal" data-target="#paymentModal" title="View">
                    <i class="fa fa-plus text-xs"></i>
                    Add Employee
                </button>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Name</th>
                            <th class="px-4 py-3 font-semibold">Department</th>
                            <th class="px-4 py-3 font-semibold">Position</th>
                            <th class="px-4 py-3 font-semibold">Date Hired</th>
                            <th class="px-4 py-3 font-semibold">Gender</th>
                            <th class="px-4 py-3 font-semibold">Date of Birth</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
>>>>>>> branch1
    </div>
    
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
<<<<<<< HEAD
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
=======
            <div class="modal-content border-0 rounded-xl shadow-lg">
                <div class="modal-header border-b border-gray-100 bg-gray-50/50 rounded-t-xl px-6 py-4">
                    <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title font-bold text-[#192965]" id="myModalLabel">Add Employee</h4>
                </div>
                <div class="modal-body p-6">
                    <form id="frmTasks" name="frmTasks" class="space-y-4" novalidate="">
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name :</label>
                            <input type="text" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" id="last_name" name="last_name" >
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name :</label>
                            <input type="text" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" id="first_name" name="first_name"  value="">
                        </div>

                        <div>
                            <label for="mid_name" class="block text-sm font-medium text-gray-700 mb-1">Middle Name :</label>
                            <input type="text" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" id="mid_name" name="mid_name"  value="">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender :</label>
                            <select id="gender" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" name="gender" >
                                <option value="" selected>Select Category</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_hired" class="block text-sm font-medium text-gray-700 mb-1">Date Hired :</label>
                            <input type="date" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" id="date_hired" name="date_hired"  value="">
                        </div>

                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth :</label>
                            <input type="date" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" id="birth_date" name="birth_date"  value="">
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department :</label>
                            <select id="department" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" name="department" >
                                <option value="" selected>Select Department</option>
                            </select>
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position :</label>
                            <select id="position" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" name="position" >
                                <option value="" selected>Select Position</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-t border-gray-100 bg-gray-50/50 rounded-b-xl px-6 py-4 flex gap-2 justify-end">
                    <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors" id="btn-danger">Clear Fields</button>
                    <button type="button" class="bg-[#192965] hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-md transition-colors" id="btn-save">Submit</button>
>>>>>>> branch1
                </div>
            </div>
        </div>
    </div>
@endsection
