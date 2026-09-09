@extends('layouts.app')
@section('content')
    
<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">{{ strtoupper($department->department_name) }}</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Manage sub-units, teams, and organizational subdivisions</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="/department" class="hover:text-slate-700 transition-colors">Groups</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">{{ $department->department_name }}</li>
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
                    <h2 class="text-base font-bold text-slate-800">SubGroups Directory</h2>
                    <span class="admin-table-badge">{{ count($sub_department) }} subgroups</span>
                </div>
                <p class="text-xs text-slate-400">Sub-units and teams under {{ $department->department_name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="/department" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-lg transition-colors">
                <i class="fa fa-arrow-left text-[10px]"></i> Back to Groups
            </a>
            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" data-toggle="modal" data-target="#addSubDepartmentModal" data-department_code="{{$department->department_code}}">
                <i class="fa fa-plus text-xs"></i> Add SubGroup
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
                    <th>SubGroup Name</th>
                    <th>Group Code</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sub_department as $sub_departments)
                    <tr>
                        <td class="font-mono text-xs text-slate-500">#{{$sub_departments->id}}</td>
                        <td class="font-semibold text-slate-800">{{$sub_departments->sub_department_name}}</td>
                        <td class="font-mono text-xs text-slate-500">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                                {{$sub_departments->department_code}}
                            </span>
                        </td>
                        <td class="whitespace-nowrap text-center">
                            <div class="admin-action-btn-group">
                                <button type="button" class="admin-btn-action admin-btn-action-labeled admin-btn-action-edit" title="Edit SubGroup">
                                    <i class="fa fa-pencil"></i>
                                    <span>Edit</span>
                                </button>
                                <button type="button" class="admin-btn-action admin-btn-action-labeled admin-btn-action-delete" title="Delete SubGroup">
                                    <i class="fa fa-trash-o"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-sitemap text-lg"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-600">No SubGroups yet</p>
                            <p class="text-xs text-slate-400 mt-1">Add teams or divisions for this department using the button above.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add SubGroup Modal -->
<div class="modal fade" id="addSubDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h4 class="modal-title font-bold text-slate-800 text-lg" id="exampleModalLabel">Add SubGroup</h4>
                    <p class="text-xs text-slate-500 font-normal">Add a subdivision to {{ $department->department_name }}</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="addSubDepartment" name="addSubDepartment" novalidate="">
                    <input type="hidden" name="generated_code" id="generated_code" value="{{$department->generated_code}}">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="sub_group_name">SubGroup Name <span class="text-rose-500">*</span></label>
                        <input type="text" class="form-control w-full text-capitalize" id="sub_group_name" name="sub_group_name" placeholder="e.g. Sales Team Alpha" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5" id="btn_addSubGroup">
                    <i class="fa fa-plus text-xs"></i> Add SubGroup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/department/department.js') }}"></script>
@endsection