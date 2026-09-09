@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Loans Ledger</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Manage company and statutory loan ledgers and payroll deductions</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="/" class="hover:text-slate-700 transition-colors">Home</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Loans</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="admin-table-card mb-8">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-credit-card"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Loans Directory</h2>
                    <span class="admin-table-badge">{{ count($loans) }} loans</span>
                </div>
                <p class="text-xs text-slate-400">All registered employee loans and current balances</p>
            </div>
        </div>
        <div>
            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" data-toggle="modal" data-target="#addSSSLoan">
                <i class="fa fa-plus text-xs"></i> Add Loan
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Loan Type</th>
                    <th>Date Started</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center">Remaining Term</th>
                    <th class="text-right">Balance</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr>
                        <td class="font-semibold text-slate-800">{{ $loan->employee ? $loan->employee->full_name : 'N/A' }}</td>
                        <td>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $loan->loan_name }}
                            </span>
                        </td>
                        <td class="text-xs text-slate-500">{{ $loan->loan_date }}</td>
                        <td class="text-right font-mono text-xs font-medium text-slate-700">₱{{ number_format($loan->loan_amount, 2) }}</td>
                        <td class="text-center font-mono text-xs text-slate-600">{{ $loan->remaining_term }} mos</td>
                        <td class="text-right font-mono text-xs font-bold text-slate-800">₱{{ number_format($loan->balance, 2) }}</td>
                        <td class="admin-table-actions whitespace-nowrap text-right">
                            <button class="admin-btn-action admin-btn-action-edit" type="button" data-toggle="modal" data-target="#editLoan" data-id="{{ $loan->id }}" title="Edit Loan">
                                <i class="fa fa-pencil"></i>
                                <span>Edit</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-credit-card text-lg"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-600">No loan records found</p>
                            <p class="text-xs text-slate-400 mt-1">There are no employee loans registered in the system yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Loan Modal -->
<div class="modal fade" id="editLoan" role="dialog" aria-labelledby="editLoan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h5 class="modal-title font-bold text-slate-800 text-lg">Edit Employee's Loan</h5>
                    <p class="text-xs text-slate-500 font-normal">Modify loan amounts and deduction terms</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_date_started">Date Started</label>
                        <input type="date" class="form-control w-full" id="edit_date_started">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_original_term">Original Terms</label>
                        <input type="number" class="form-control w-full" id="edit_original_term">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_remaining_term">Remaining Terms</label>
                        <input type="number" class="form-control w-full" id="edit_remaining_term">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_amountLoan">Amount of Loan</label>
                        <input type="number" class="form-control w-full" id="edit_amountLoan">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_interest">Interest</label>
                        <input type="number" class="form-control w-full" id="edit_interest">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_totalLoan">Total Loans</label>
                        <input type="number" class="form-control w-full" id="edit_totalLoan">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_deduction">Deduction</label>
                        <input type="number" class="form-control w-full" id="edit_deduction">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_balance">Balance</label>
                        <input type="number" class="form-control w-full" id="edit_balance">
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Close</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Loan Modal -->
<div class="modal fade" id="addSSSLoan" tabindex="-1" role="dialog" aria-labelledby="addSSSLoan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h5 class="modal-title font-bold text-slate-800 text-lg" id="exampleModalLongTitle">Add Employee's Loan</h5>
                    <p class="text-xs text-slate-500 font-normal">Create a new loan ledger entry</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="loan_type">Loan Type</label>
                        <select id="loan_type" class="form-control w-full" name="loan_type">
                            <option value="" selected>Loan Type</option>
                            <option value="1">SSS LOAN</option>
                            <option value="2">PAG-IBIG LOAN</option>
                            <option value="3">COMPANY LOAN</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="department">Department</label>
                        <select id="department" class="form-control w-full" name="department">
                            <option value="" selected>Select Department</option>
                            @foreach($department as $departments)
                                <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employee_name">Employee Name</label>
                        <select id="employee_name" class="form-control w-full" name="employee_name">
                            <option value="" selected>Select Employee</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="date_started">Date Started</label>
                        <input type="date" class="form-control w-full" id="date_started">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="original_term">Original Terms</label>
                        <input type="number" class="form-control w-full" id="original_term">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="remaining_term">Remaining Terms</label>
                        <input type="number" class="form-control w-full" id="remaining_term">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="amountLoan">Amount of Loan</label>
                        <input type="number" class="form-control w-full" id="amountLoan">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="interest">Interest</label>
                        <input type="number" class="form-control w-full" id="interest">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="totalLoan">Total Loans</label>
                        <input type="number" class="form-control w-full" id="totalLoan">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="deduction">Deduction</label>
                        <input type="number" class="form-control w-full" id="deduction">
                    </div>
                    <div class="form-group mb-0">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="balance">Balance</label>
                        <input type="number" class="form-control w-full" id="balance">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center text-sm text-slate-600 cursor-pointer">
                            <input type="checkbox" value="1" id="status" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-2">
                            <span>Deduct automatically in payroll</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Close</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" id="submit-loans">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/loan/loans.js') }}"></script>
@endsection