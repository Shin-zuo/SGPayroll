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
<div class="admin-table-card mb-8">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-sitemap"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Group Directory</h2>
                    <span class="admin-table-badge">{{ count($department) }} groups</span>
                </div>
                <p class="text-xs text-slate-400">Active organizational departments, statutory numbers, and pay frequencies</p>
            </div>
        </div>
        <div>
            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fa fa-plus text-xs"></i> Add Group
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Group Code</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($department as $departments)
                    <tr>
                        <td class="whitespace-nowrap font-bold text-slate-800">
                            {{ strtoupper($departments->department_name) }}
                        </td>
                        <td class="whitespace-nowrap font-mono text-xs text-slate-500">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                                {{ $departments->department_code }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap text-center">
                            <div class="admin-action-btn-group">
                                <a href="/department/{{$departments->id}}" class="admin-btn-action admin-btn-action-labeled admin-btn-action-view" title="SubGroups">
                                    <i class="fa fa-sitemap"></i>
                                    <span>SubGroups</span>
                                </a>
                                <a href="/payroll/{{$departments->department_name}}" target="_blank" class="admin-btn-action admin-btn-action-labeled admin-btn-action-print" title="Payroll">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Payroll</span>
                                </a>
                                <button type="button" class="admin-btn-action admin-btn-action-labeled admin-btn-action-edit" data-toggle="modal" data-target="#editDepartmentModal" data-zip="{{$departments->zip_code}}" data-telno="{{$departments->tel_no}}" data-code="{{$departments->department_code}}" data-tin="{{$departments->employer_tin}}" data-sss="{{$departments->employer_sss}}" data-address="{{$departments->department_address}}" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}" title="Edit Group">
                                    <i class="fa fa-pencil"></i>
                                    <span>Edit</span>
                                </button>
                                <button type="button" class="admin-btn-action admin-btn-action-labeled admin-btn-action-delete btn-delete-group" data-id="{{$departments->id}}" data-name="{{$departments->department_name}}" title="Delete Group">
                                    <i class="fa fa-trash-o"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
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
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h4 class="modal-title font-bold text-slate-800 text-lg" id="addDepartmentModalLabel">Add New Group</h4>
                    <p class="text-xs text-slate-500 font-normal">Define department name and employer details</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="addDepartment" name="addDepartment" novalidate="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="group_name">Group Name <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control w-full text-capitalize" id="group_name" name="group_name" placeholder="e.g. Operations" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="group_code">Group Code <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control w-full text-capitalize" id="group_code" name="group_code" placeholder="e.g. OPS" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employer_tin">Employer TIN #</label>
                            <input type="number" class="form-control w-full" id="employer_tin" name="employer_tin" placeholder="TIN Number">
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employer_sss">Employer SSS / No #</label>
                            <input type="number" class="form-control w-full" id="employer_sss" name="employer_sss" placeholder="SSS Number">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employer_telNo">Telephone No #</label>
                            <input type="number" class="form-control w-full" id="employer_telNo" name="employer_TelNo" placeholder="Contact Number">
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employer_zip">Zip Code</label>
                            <input type="number" class="form-control w-full" id="employer_zip" name="employer_zip" placeholder="Zip Code">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="group_address">Department Address</label>
                        <textarea class="form-control w-full" rows="2" id="group_address" name="group_address" placeholder="Physical Address"></textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="payroll_type">Payroll Type <span class="text-rose-500">*</span></label>
                        <select id="payroll_type" class="form-control w-full" name="payroll_type">
                            <option value="1">MONTHLY</option>
                            <option value="2">SEMI-MONTHLY</option>
                            <option value="3">WEEKLY</option>
                            <option value="4">DAILY</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5" id="btn_addGroup">
                    <i class="fa fa-plus text-xs"></i> Add Group
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Group Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h4 class="modal-title font-bold text-slate-800 text-lg" id="editDepartmentModalLabel">Edit Group</h4>
                    <p class="text-xs text-slate-500 font-normal">Update organizational parameters and settings</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="editDepartment" name="editDepartment" novalidate="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_group_name">Group Name <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control w-full text-capitalize" id="edit_group_name" name="edit_group_name" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_group_code">Group Code <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control w-full text-capitalize" id="edit_group_code" name="edit_group_code" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_employer_tin">Employer TIN #</label>
                            <input type="text" class="form-control w-full" id="edit_employer_tin" name="edit_employer_tin">
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_employer_sss">Employer SSS #</label>
                            <input type="text" class="form-control w-full" id="edit_employer_sss" name="edit_employer_sss">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_employer_telNo">Telephone No #</label>
                            <input type="number" class="form-control w-full" id="edit_employer_telNo" name="edit_employer_TelNo">
                        </div>
                        <div class="form-group mb-0">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_employer_zip">Zip Code</label>
                            <input type="number" class="form-control w-full" id="edit_employer_zip" name="edit_employer_zip">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_group_address">Address</label>
                        <textarea class="form-control w-full" rows="2" id="edit_group_address" name="edit_group_address"></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_payroll_type">Payroll Type</label>
                        <select id="edit_payroll_type" class="form-control w-full" name="edit_payroll_type">
                            <option value="1">MONTHLY</option>
                            <option value="2">SEMI-MONTHLY</option>
                            <option value="3">WEEKLY</option>
                            <option value="4">DAILY</option>
                        </select>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-4">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                            <i class="fa fa-calendar-check-o text-blue-600"></i> 13th Month Period
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group mb-0">
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_13monthFrom">From</label>
                                <input type="date" class="form-control w-full" name="edit_13monthFrom" id="edit_13monthFrom" value="{{date('Y-m')}}">
                            </div>
                            <div class="form-group mb-0">
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_13monthTo">To</label>
                                <input type="date" class="form-control w-full" name="edit_13monthTo" id="edit_13monthTo" value="{{date('Y-m')}}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5" id="editNameGroup">
                    <i class="fa fa-check text-xs"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pay Period Modal -->
<div class="modal fade" id="periodModal" tabindex="-1" role="dialog" aria-labelledby="periodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h4 class="modal-title font-bold text-slate-800 text-lg" id="periodModalLabel">Pay Period</h4>
                    <p class="text-xs text-slate-500 font-normal">Set the payroll date range</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6 space-y-4">
                <form id="periodForm">
                    <div class="form-group mb-3">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="date_from">Date From</label>
                        <input type="date" class="form-control w-full" id="date_from" name="date_from">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="date_to">Date To</label>
                        <input type="date" class="form-control w-full" id="date_to" name="date_to">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" id="savePeriod">Save Period</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/department/department.js') }}"></script>
@endsection