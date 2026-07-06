@extends('layouts.app')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Admin Dashboard</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="#" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Employees</li>
        </ol>
    </nav>
</div>

<!-- Stat Cards (Top Row) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
        $totalEmp = count($employee);
        $activeEmp = collect($employee)->where('status', '!=', 'Inactive')->count();
    @endphp
    <!-- Total Users -->
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
        <div class="absolute top-4 left-4 text-blue-500">
            <i class="fa fa-users text-lg"></i>
        </div>
        <div class="ml-10">
            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Total Employees</h3>
            <p class="text-2xl font-bold text-slate-800">{{ $totalEmp }}</p>
        </div>
    </div>

    <!-- Active Users -->
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
        <div class="absolute top-4 left-4 text-green-500">
            <i class="fa fa-user-check text-lg"></i>
        </div>
        <div class="ml-10">
            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Active Employees</h3>
            <p class="text-2xl font-bold text-slate-800">{{ $activeEmp }}</p>
        </div>
    </div>

    <!-- Pending Leaves (Placeholder) -->
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
        <div class="absolute top-4 left-4 text-yellow-500">
            <i class="fa fa-calendar-alt text-lg"></i>
        </div>
        <div class="ml-10">
            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Pending Leaves</h3>
            <p class="text-2xl font-bold text-slate-800">0</p>
        </div>
    </div>

    <!-- Departments (Placeholder) -->
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
        <div class="absolute top-4 left-4 text-purple-500">
            <i class="fa fa-sitemap text-lg"></i>
        </div>
        <div class="ml-10">
            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Departments</h3>
            <p class="text-2xl font-bold text-slate-800">4</p>
        </div>
    </div>
</div>

<!-- Data Table Section -->
<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-base font-semibold text-slate-800">Employee Directory</h2>
        <div class="flex items-center gap-2">
            <button type="button" id="btn-import-employee-csv"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors flex items-center gap-1.5">
                <i class="fa fa-file-csv"></i> Import CSV
            </button>
            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors" data-toggle="modal" data-target="#addEmployee" title="Add Employee">
                <i class="fa fa-plus mr-1.5"></i> Add Employee
            </button>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="emptable" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2 border-b border-slate-200">ID</th>
                    <th class="px-4 py-2 border-b border-slate-200">Name</th>
                    <th class="px-4 py-2 border-b border-slate-200">Department</th>
                    <th class="px-4 py-2 border-b border-slate-200">Position</th>
                    <th class="px-4 py-2 border-b border-slate-200">Status</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($employee as $employees)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->id}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-800">{{strtoupper($employees->full_name)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{strtoupper($employees->department)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employees->position}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        @if($employees->status == 'Inactive')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/employee/account/{{$employees->id}}" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank" title="View Account">
                            <i class="fa fa-user-edit"></i>
                        </a>
                        <a href="#" data-toggle="modal" data-id="{{$employees->id}}" data-target=".bd-example-modal-sm" class="text-red-600 hover:text-red-900" title="Set Inactive">
                            <i class="fa fa-user-times"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
                                    <input type="text" class="form-control  has-error" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="form-group error">
                                <label for="inputFirstName" class="col-sm-4 control-label">First Name :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="first_name" name="first_name" required>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputMidName" class="col-sm-4 control-label">Middle Name :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control  has-error" id="mid_name" name="mid_name"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputGender" class="col-sm-4 control-label" >Gender :</label>
                                <div class="col-sm-8">
                                    <select id="gender" class="form-control" name="gender" required>
                                        <option value="" selected>Select Category</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputStatus" class="col-sm-4 control-label">Status :</label>
                                <div class="col-sm-8">
                                    <select id="status" class="form-control" name="status" required>
                                        <option value="" selected>Select Status</option>
                                        <option value="Single" >Single</option>
                                        <option value="Married" >Married</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputDateHired" class="col-sm-4 control-label" >Date Hired :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control has-error" id="date_hired" name="date_hired"  value="" required>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="inputBirthDate" class="col-sm-4 control-label" >Date of Birth :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control has-error" id="birth_date" name="birth_date"  value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDepartment" class="col-sm-4 control-label">Group :</label>
                                <div class="col-sm-8">
                                    <select id="department" class="form-control" name="department" required>
                                        <option value="" selected disabled>Select Department</option>
                                        @foreach($department as $departments)
                                        <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSubDepartment" class="col-sm-4 control-label" >SubGroup :</label>
                                <div class="col-sm-8">
                                    <select id="sub_department" class="form-control" name="sub_department" required>
                                        <option value="" selected disabled>Select Sub Department</option>
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
                                <label for="inputEmail" class="col-sm-4 control-label">Email :</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control has-error" id="emp_email" name="emp_email" >
                                    <small class="text-muted">This will be the employee's login email. Default password: testPass</small>
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

<!-- CSV Import Modal (Task 5) -->
<div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="importCsvModalLabel">Import Employees from CSV</h4>
            </div>
            <div class="modal-body">
                <!-- Step 1: Format Guide -->
                <div id="import-step-1">
                    <p class="mb-4 text-slate-600">Please format your CSV file exactly as shown below. The headers must match exactly in order to insert appropriate data. Note that an email will automatically create a portal user account with the password <strong>"testPass"</strong>.</p>
                    
                    <div style="max-height: 250px; overflow-y: auto;" class="border rounded mb-4">
                        <table class="table table-bordered table-striped text-xs mb-0">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th>Column Name</th>
                                    <th>Required</th>
                                    <th>Accepted Value Example / Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><strong>employee_id</strong></td><td>No</td><td>EMP-001 (Unique Code)</td></tr>
                                <tr><td><strong>last_name</strong></td><td><span class="text-red-600">Yes</span></td><td>Smith</td></tr>
                                <tr><td><strong>first_name</strong></td><td><span class="text-red-600">Yes</span></td><td>John</td></tr>
                                <tr><td><strong>middle_name</strong></td><td>No</td><td>Doe</td></tr>
                                <tr><td><strong>gender</strong></td><td>No</td><td>Male / Female</td></tr>
                                <tr><td><strong>status</strong></td><td>No</td><td>Single / Married</td></tr>
                                <tr><td><strong>date_hired</strong></td><td>No</td><td>YYYY-MM-DD (e.g. 2026-07-03)</td></tr>
                                <tr><td><strong>birth_date</strong></td><td>No</td><td>YYYY-MM-DD</td></tr>
                                <tr><td><strong>department</strong></td><td>No</td><td>Department Name</td></tr>
                                <tr><td><strong>position</strong></td><td>No</td><td>Position/Job Title</td></tr>
                                <tr><td><strong>address</strong></td><td>No</td><td>Street Address</td></tr>
                                <tr><td><strong>email</strong></td><td>No</td><td>john@example.com (Creates user account)</td></tr>
                                <tr><td><strong>sss_number</strong></td><td>No</td><td>Numbers only</td></tr>
                                <tr><td><strong>tin_number</strong></td><td>No</td><td>Numbers only</td></tr>
                                <tr><td><strong>hdmf_number</strong></td><td>No</td><td>Numbers only (Pag-IBIG)</td></tr>
                                <tr><td><strong>philhealth_number</strong></td><td>No</td><td>Numbers only</td></tr>
                                <tr><td><strong>ucpb_number</strong></td><td>No</td><td>Numbers only</td></tr>
                                <tr><td><strong>basic_pay</strong></td><td>No</td><td>Decimal/Float (e.g. 25000)</td></tr>
                                <tr><td><strong>cola</strong></td><td>No</td><td>Decimal/Float</td></tr>
                                <tr><td><strong>other_nt_pay</strong></td><td>No</td><td>Decimal/Float</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="button" id="btn-proceed-upload" class="btn btn-primary">Proceed to Upload</button>
                    </div>
                </div>

                <!-- Step 2: Upload Input -->
                <div id="import-step-2" style="display: none;">
                    <form id="employeeImportForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="import_file" class="control-label">Select CSV File :</label>
                            <input type="file" id="import_file" name="import_file" class="form-control" accept=".csv,text/csv,text/plain" required>
                        </div>
                        <div id="import-results" style="display:none;" class="alert mb-4"></div>
                        <div class="text-center mt-4">
                            <button type="button" id="btn-back-step-1" class="btn btn-secondary mr-2">Back</button>
                            <button type="submit" id="btn-submit-import" class="btn btn-success">Import Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/employee.js?v={{ time() }}"></script>
<script>
    $(document).ready(function() {
        $('#emptable').DataTable();

        $('#btn-import-employee-csv').on('click', function() {
            // Reset to Step 1 when modal is opened
            $('#import-step-1').show();
            $('#import-step-2').hide();
            $('#import_file').val('');
            $('#import-results').hide().empty();
            $('#importCsvModal').modal('show');
        });

        $('#btn-proceed-upload').on('click', function() {
            $('#import-step-1').hide();
            $('#import-step-2').show();
        });

        $('#btn-back-step-1').on('click', function() {
            $('#import-step-2').hide();
            $('#import-step-1').show();
        });

        $('#employeeImportForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#btn-submit-import').prop('disabled', true).text('Importing...');
            $('#import-results').hide().removeClass('alert-success alert-danger alert-warning').empty();

            $.ajax({
                url: '/employee/batch-import',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json' // Forces Laravel to send JSON validation errors instead of redirects
                },
                success: function(response) {
                    $('#btn-submit-import').prop('disabled', false).text('Import Now');
                    
                    var alertClass = 'alert-success';
                    var html = '<strong>' + response.message + '</strong>';

                    if (response.failed && response.failed.length > 0) {
                        alertClass = 'alert-warning';
                        html += '<hr><p class="mb-1 font-bold">Failed rows:</p><ul class="pl-4 mb-0 text-xs">';
                        response.failed.forEach(function(item) {
                            html += '<li>Row ' + item.row + ': ' + item.reason + '</li>';
                        });
                        html += '</ul>';
                    }

                    $('#import-results').addClass(alertClass).html(html).show();
                    
                    // Reload table if anything succeeded
                    if (response.success > 0) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    $('#btn-submit-import').prop('disabled', false).text('Import Now');
                    var errorMsg = 'An error occurred during import.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#import-results').addClass('alert-danger').html('<strong>' + errorMsg + '</strong>').show();
                }
            });
        });
    });
</script>
