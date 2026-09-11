@extends('layouts.app')
@section('content')
<!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Loans Management</h1>
        <p class="text-sm text-slate-500 mt-0.5">Track employee loans, amortization schedules, deductions, and remaining balances.</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-700 transition-colors">Employees</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li><a href="/employee/account/{{ $employee->id }}" class="hover:text-slate-700 transition-colors">{{ $employee->full_name }}</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Loans</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 dark:bg-slate-900/60 px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm shadow-xs">
                    <i class="fas fa-receipt"></i>
                </span>
                Loans for {{ strtoupper($employee->full_name) }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Employee ID: <span class="font-mono font-semibold text-slate-700 dark:text-slate-200">{{ $employee->employee_id }}</span> &bull; Active Loan Records</p>
        </div>
        <div class="flex items-center gap-2.5">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-transparent dark:border-slate-700/60 text-xs font-semibold">
                {{ $employee_loan->count() }} records
            </span>
            <a href="/employee/account/{{ $employee->id }}" class="btn btn-secondary text-xs font-medium flex items-center gap-1.5">
                <i class="fa fa-arrow-left text-xs"></i> Back to Account
            </a>
            <button type="button" class="btn btn-primary text-xs font-medium flex items-center gap-1.5" data-toggle="modal" data-target="#addLoansModal">
                <i class="fa fa-plus text-xs"></i> Add Loan
            </button>
        </div>
    </div>

    <div class="p-5 overflow-x-auto">
        <table class="w-full text-left border-collapse" style="font-size: 12px;">
            <thead>
                <tr class="bg-slate-100/75 dark:bg-slate-800/80 font-semibold text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <th class="py-2.5 px-3">Date Started</th>
                    <th class="py-2.5 px-3">Loan Type</th>
                    <th class="py-2.5 px-3 text-right">Amount</th>
                    <th class="py-2.5 px-3 text-center">Orig. Term</th>
                    <th class="py-2.5 px-3 text-center">Rem. Term</th>
                    <th class="py-2.5 px-3">Promissory Note</th>
                    <th class="py-2.5 px-3 text-right">Deduction</th>
                    <th class="py-2.5 px-3 text-center" style="width: 90px;">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($employee_loan as $employee_loans)
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="py-2.5 px-3 font-mono text-slate-600 dark:text-slate-300" style="font-size: 11px;">{{$employee_loans->deduction_date}}</td>
                    <td class="py-2.5 px-3 font-semibold text-slate-800 dark:text-white" style="font-size: 12px;">{{$employee_loans->loan_name}}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-700 dark:text-slate-100" style="font-size: 12px;">₱{{number_format($employee_loans->loan_amount, 2)}}</td>
                    <td class="py-2.5 px-3 text-center text-slate-600 dark:text-slate-300" style="font-size: 11px;">{{$employee_loans->original_term}}</td>
                    <td class="py-2.5 px-3 text-center text-slate-600 dark:text-slate-300" style="font-size: 11px;">{{$employee_loans->remaining_term}}</td>
                    <td class="py-2.5 px-3 text-slate-500 dark:text-slate-300 max-w-xs truncate" style="font-size: 11px;" title="{{$employee_loans->promissory_note}}">{{$employee_loans->promissory_note ?: '—'}}</td>
                    <td class="py-2.5 px-3 text-right font-bold text-rose-600 dark:text-rose-400" style="font-size: 12px;">₱{{number_format($employee_loans->deduction, 2)}}</td>
                    <td class="py-2.5 px-3 text-center">
                        <div class="admin-action-btn-group">
                            <button type="button" data-toggle="modal" class="admin-btn-action admin-btn-action-edit" data-id="{{$employee_loans->id}}" data-target="#editLoan" title="Edit Loan">
                                <i class="fa fa-pen"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-id="{{$employee_loans->id}}" data-target=".bd-example-modal-sm" id="deleteLoan" class="admin-btn-action admin-btn-action-danger" title="Delete Loan">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-12 px-4 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3 text-xl">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-600 mb-1">No loans recorded</h3>
                            <p class="text-xs text-slate-400 max-w-sm mb-4">No active or historical loans found for this employee.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{--addLoans Modal--}}
<div class="modal fade" id="addLoansModal" tabindex="-1" role="dialog" aria-labelledby="addLoansModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="admin-modal-hero">
                <div>
                    <h4 class="modal-title">Add Loan Information</h4>
                    <p class="modal-subtitle">Create a new loan amortization schedule for this employee.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body loan">
                <input type="hidden" value="{{$employee->employee_id}}" id="employee_id">
                <input type="hidden" value="{{$employee->id}}" id="id">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="loan_type">Loan Type</label>
                        <select id="loan_type" class="form-control w-full" name="loan_type">
                            <option value="1">SSS SALARY LOAN</option>
                            <option value="2">SSS CALAMITY LOAN</option>
                            <option value="3">PAG-IBIG LOAN</option>
                            <option value="8">PAG-IBIG CALAMITY LOAN</option>
                            <option value="5">PAG-IBIG SAFE LOAN</option>
                            <option value="6">INSURANCE LOAN</option>
                            <option value="7">SSS EMERGENCY LOAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Promissory Note (Others Only)</label>
                        <input type="text" class="form-control w-full" id="promissory_note" placeholder="Promissory Note" disabled>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Date Granted</label>
                        <input type="date" class="form-control w-full" id="date_granted">
                    </div>
                </div>

                <hr class="border-slate-100 my-4">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Date Started</label>
                        <input type="date" class="form-control w-full" id="date_started">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Original Terms (Months)</label>
                        <input type="number" class="form-control w-full" id="original_term">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Remaining Terms (Months)</label>
                        <input type="number" class="form-control w-full" id="remaining_term">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Amount of Loan</label>
                        <input type="number" class="form-control w-full" id="amountLoan">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Interest</label>
                        <input type="number" class="form-control w-full" id="interest">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Total Loans</label>
                        <input type="number" class="form-control w-full" id="totalLoan">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Deduction per period</label>
                        <input type="number" class="form-control w-full" id="deduction">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Balance</label>
                        <input type="number" class="form-control w-full" id="balance">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center text-sm text-slate-600 cursor-pointer">
                            <input type="checkbox" value="1" id="status" name="status" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-2">
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

{{--editLoan Modal--}}
<div class="modal fade" id="editLoan" role="dialog" aria-labelledby="editLoan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="modal-header admin-modal-hero">
                <div>
                    <h5 class="modal-title font-bold text-slate-800 text-lg">Edit Employee's Loan</h5>
                    <p class="text-xs text-slate-500 font-normal">Modify existing loan details and deduction terms</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body loan">
                <input type="hidden" id="editId" name="editId">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="edit_loan_type">Loan Type</label>
                        <select class="form-control w-full" id="edit_loan_type" name="edit_loan_type" disabled>
                            <option value="" selected>Loan Type</option>
                            <option value="1">SSS LOAN</option>
                            <option value="2">PAG-IBIG LOAN</option>
                            <option value="3">COMPANY LOAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Date Started</label>
                        <input type="date" class="form-control w-full" id="edit_date_deduction" name="edit_date_deduction">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Original Terms</label>
                        <input type="number" class="form-control w-full" id="edit_original_term">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Remaining Terms</label>
                        <input type="number" class="form-control w-full" id="edit_remaining_term">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Amount of Loan</label>
                        <input type="number" class="form-control w-full" id="edit_amountLoan">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Interest</label>
                        <input type="number" class="form-control w-full" id="edit_interest">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Total Loans</label>
                        <input type="number" class="form-control w-full" id="edit_totalLoan">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Deduction</label>
                        <input type="number" class="form-control w-full" id="edit_deduction">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Balance</label>
                        <input type="number" class="form-control w-full" id="edit_balance">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="flex items-center pt-2">
                        <label class="inline-flex items-center text-sm text-slate-600 cursor-pointer">
                            <input type="checkbox" value="" id="EditStatus" name="EditStatus" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-2">
                            <span>Deduct automatically in payroll</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Close</button>
                <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow transition" id="editLoanBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{--delete check Modal--}}
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content overflow-hidden border-0 shadow-xl rounded-2xl">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
                    <i class="fa fa-trash text-xl"></i>
                </div>
                <h5 class="text-base font-bold text-slate-800 mb-1">Delete Loan</h5>
                <p class="text-xs text-slate-500 mb-4">Are you sure you want to delete this loan record? This action cannot be undone.</p>
                <form>
                    <input type="hidden" name="id" id="id">
                </form>
                <div class="flex items-center justify-center gap-2">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition" data-dismiss="modal">Cancel</button>
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm hover:shadow transition" id="btnYes">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/loan/loans.js') }}"></script>
@endsection
