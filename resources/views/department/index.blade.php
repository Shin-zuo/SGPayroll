@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Manage Groups</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Organize departments, statutory numbers, and pay frequencies.</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="#" class="hover:text-slate-700 transition-colors">Home</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Groups</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden mb-8">
    <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3 bg-white">
        <div>
            <h2 class="text-base font-bold text-slate-900">Group Directory</h2>
            <p class="text-xs text-slate-400 mt-0.5">Active organizational departments</p>
        </div>
        <button type="button" class="btn btn-primary text-xs font-medium flex items-center gap-2" data-toggle="modal" data-target="#addDepartmentModal">
            <i class="fa fa-plus text-xs"></i> Add Group
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3 border-b border-slate-200/80">Group Name</th>
                    <th class="px-5 py-3 border-b border-slate-200/80">Group Code</th>
                    <th class="px-5 py-3 border-b border-slate-200/80 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($department as $departments)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold text-slate-800">
                            {{ strtoupper($departments->department_name) }}
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap text-xs font-mono text-slate-500">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                                {{ $departments->department_code }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap text-right text-xs font-medium space-x-1.5">
                            <a href="/department/{{$departments->id}}" class="inline-flex items-center px-2.5 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors font-medium">
                                <i class="fa fa-layer-group mr-1.5 text-[10px]"></i> SubGroups
                            </a>
                            <a href="/payroll/{{$departments->department_name}}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-md text-indigo-600 hover:bg-indigo-50 transition-colors font-medium">
                                <i class="fa fa-file-invoice-dollar mr-1.5 text-[10px]"></i> Payroll
                            </a>
                            <button type="button" class="inline-flex items-center px-2.5 py-1 rounded-md text-slate-600 hover:bg-slate-100 transition-colors font-medium" data-toggle="modal" data-target="#editDepartmentModal" data-zip="{{$departments->zip_code}}" data-telno="{{$departments->tel_no}}" data-code="{{$departments->department_code}}" data-tin="{{$departments->employer_tin}}" data-sss="{{$departments->employer_sss}}" data-address="{{$departments->department_address}}" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}">
                                <i class="fa fa-pen mr-1 text-[10px]"></i> Edit
                            </button>
                            <button type="button" class="btn-delete-group inline-flex items-center px-2.5 py-1 rounded-md text-rose-600 hover:bg-rose-50 transition-colors font-medium" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}">
                                <i class="fa fa-trash-alt mr-1 text-[10px]"></i> Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Group Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title font-bold text-slate-900" id="addDepartmentModalLabel">Add New Group</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Define department name and employer details.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDepartment" name="addDepartment" novalidate="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="group_name">Group Name <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control text-capitalize" id="group_name" name="group_name" placeholder="e.g. Operations" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="group_code">Group Code <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control text-capitalize" id="group_code" name="group_code" placeholder="e.g. OPS" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="employer_tin">Employer TIN #</label>
                            <input type="number" class="form-control" id="employer_tin" name="employer_tin" placeholder="TIN Number">
                        </div>
                        <div class="form-group mb-0">
                            <label for="employer_sss">Employer SSS / No #</label>
                            <input type="number" class="form-control" id="employer_sss" name="employer_sss" placeholder="SSS Number">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="employer_telNo">Telephone No #</label>
                            <input type="number" class="form-control" id="employer_telNo" name="employer_TelNo" placeholder="Contact Number">
                        </div>
                        <div class="form-group mb-0">
                            <label for="employer_zip">Zip Code</label>
                            <input type="number" class="form-control" id="employer_zip" name="employer_zip" placeholder="Zip Code">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="group_address">Department Address</label>
                        <textarea class="form-control" rows="2" id="group_address" name="group_address" placeholder="Physical Address"></textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label for="payroll_type">Payroll Type <span class="text-rose-500">*</span></label>
                        <select id="payroll_type" class="form-control" name="payroll_type">
                            <option value="1">MONTHLY</option>
                            <option value="2">SEMI-MONTHLY</option>
                            <option value="3">WEEKLY</option>
                            <option value="4">DAILY</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_addGroup">
                    <i class="fa fa-plus mr-1.5 text-xs"></i> Add Group
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Group Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title font-bold text-slate-900" id="editDepartmentModalLabel">Edit Group</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Update organizational parameters and settings.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDepartment" name="editDepartment" novalidate="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="edit_group_name">Group Name <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control text-capitalize" id="edit_group_name" name="edit_group_name" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="edit_group_code">Group Code <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control text-capitalize" id="edit_group_code" name="edit_group_code" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="edit_employer_tin">Employer TIN #</label>
                            <input type="text" class="form-control" id="edit_employer_tin" name="edit_employer_tin">
                        </div>
                        <div class="form-group mb-0">
                            <label for="edit_employer_sss">Employer SSS #</label>
                            <input type="text" class="form-control" id="edit_employer_sss" name="edit_employer_sss">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="edit_employer_telNo">Telephone No #</label>
                            <input type="number" class="form-control" id="edit_employer_telNo" name="edit_employer_TelNo">
                        </div>
                        <div class="form-group mb-0">
                            <label for="edit_employer_zip">Zip Code</label>
                            <input type="number" class="form-control" id="edit_employer_zip" name="edit_employer_zip">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="edit_group_address">Address</label>
                        <textarea class="form-control" rows="2" id="edit_group_address" name="edit_group_address"></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="edit_payroll_type">Payroll Type</label>
                        <select id="edit_payroll_type" class="form-control" name="edit_payroll_type">
                            <option value="1">MONTHLY</option>
                            <option value="2">SEMI-MONTHLY</option>
                            <option value="3">WEEKLY</option>
                            <option value="4">DAILY</option>
                        </select>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-4">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                            <i class="fa fa-calendar-alt text-blue-600"></i> 13th Month Period
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group mb-0">
                                <label for="edit_13monthFrom">From</label>
                                <input type="date" class="form-control" name="edit_13monthFrom" id="edit_13monthFrom" value="{{date('Y-m')}}">
                            </div>
                            <div class="form-group mb-0">
                                <label for="edit_13monthTo">To</label>
                                <input type="date" class="form-control" name="edit_13monthTo" id="edit_13monthTo" value="{{date('Y-m')}}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="editNameGroup">
                    <i class="fa fa-check mr-1.5 text-xs"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pay Period Modal -->
<div class="modal fade" id="periodModal" tabindex="-1" role="dialog" aria-labelledby="periodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title font-bold text-slate-900" id="periodModalLabel">Pay Period</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Set the payroll date range.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <form id="periodForm">
                    <div class="form-group mb-3">
                        <label for="date_from">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>
                    <div class="form-group mb-0">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePeriod">Save Period</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/department/department.js') }}"></script>
@endsection