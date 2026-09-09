@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Loan Types</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Manage deductible loan classifications and codes</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="/deduction" class="hover:text-slate-700 transition-colors">Deductions</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Loan Types</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="admin-table-card mb-8">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-tags"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Loan Types Directory</h2>
                    <span class="admin-table-badge">{{ count($loan) }} types</span>
                </div>
                <p class="text-xs text-slate-400">Registered loan categories available for employee deductions</p>
            </div>
        </div>
        <div>
            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" data-toggle="modal" data-target="#addLoansModal">
                <i class="fa fa-plus text-xs"></i> Add Loan Type
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="w-32">Loan Code</th>
                    <th>Loan Type Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loan as $loans)
                    <tr>
                        <td class="font-mono text-xs font-bold text-slate-700">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                                {{ $loans->loan_id }}
                            </span>
                        </td>
                        <td class="font-semibold text-slate-800">{{ $loans->loan_type_name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-tags text-lg"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-600">No loan types defined</p>
                            <p class="text-xs text-slate-400 mt-1">Add loan types to categorize employee borrowings.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{--addLoans Modal--}}
<div class="modal fade" tabindex="-1" id="addLoansModal" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h5 class="modal-title font-bold text-slate-800 text-lg">Add Loan Type</h5>
                    <p class="text-xs text-slate-500 font-normal">Define a new loan classification</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="frmTasks" name="frmTasks" novalidate="">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="loan_type_name">Loan Type Name <span class="text-rose-500">*</span></label>
                        <input type="text" class="form-control w-full text-capitalize" id="loan_type_name" name="loan_type_name" placeholder="e.g. EDUCATION LOAN" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5" id="btn_addLoanType">
                    <i class="fa fa-plus text-xs"></i> Add Type
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/loan/loans.js') }}"></script>
@endsection