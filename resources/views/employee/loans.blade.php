@extends('layouts.app')
@section('content')
<<<<<<< HEAD

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <h3>Loans</h3>
                <hr>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addLoansModal" title="View" data-content="" >
                    <span class="glyphicon glyphicon-plus"></span>
                    Add Loans
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="" title="View" data-content="" >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Back
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center"><strong>{{$employee->full_name}}</strong></h2>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date Started</th>
                        <th>Loan Type</th>
                        <th>Loan Amount</th>
                        <th>Original Term</th>
                        <th>Remaining Term</th>
                        <th>Note</th>
                        <th>Deduction</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employee_loan as $employee_loans)
                    <tr>
                        <td><strong>{{$employee_loans->deduction_date}}</strong></td>
                        <td>{{$employee_loans->loan_name}}</td>
                        <td>{{$employee_loans->loan_amount}}</td>
                        <td>{{$employee_loans->original_term}}</td>
                        <td>{{$employee_loans->remaining_term}}</td>
                        <td>{{$employee_loans->promissory_note}}</td>
                        <td>{{$employee_loans->deduction}}</td>

                        <td>
                            <a data-toggle="modal" class="btn btn-success" data-id="{{$employee_loans->id}}" data-target="#editLoan">Edit</a>
                            <a data-toggle="modal"  data-id="{{$employee_loans->id}}" data-target=".bd-example-modal-sm" id="deleteLoan" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{--addLoans Modal--}}
    <div class="modal fade" id="addLoansModal" tabindex="-1" role="dialog" aria-labelledby="addLoansModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Loans Info</h5>
                </div>
                <div class="modal-body loan">
                    <div class="row">
                        <div class="col-sm-12">
                            <form>
                                <input type="hidden" value="{{$employee->employee_id}}" id="employee_id">
                                <input type="hidden" value="{{$employee->id}}" id="id">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputLoan">Loan Type</label>
                                         <select id="loan_type" class="form-control"  name="loan_type" >
                                          <option value="1">SSS SALARY LOAN</option>
                                             <option value="2">SSS CALAMITY LOAN</option>
                                          <option value="3">PAG-IBIG LOAN</option>
                                          <option value="4">ADVANCEMENT LOAN</option>
                                             <option value="5">COOP LOAN</option>
                                             <option value="6">HMO</option>
                                             <option value="7">OTHERS</option>

                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>(Pag-IBIG LOAN and OTHERS ONLY)</label>
                                        <input type="text" class="form-control" id="promissory_note" placeholder="Promissory Note" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="loanType">Date Granted</label>
                                        <input type="date" class="form-control" id="date_granted">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12"><hr></div>

                        <div class="col-sm-12">
                            <form>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="loanType">Date Started</label>
                                        <input type="date" class="form-control" id="date_started">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="origTerms">Original Terms</label>
                                        <input type="number" class="form-control" id="original_term">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="remTerms">Remaining Terms</label>
                                        <input type="number" class="form-control" id="remaining_term">
                                    </div>
                                </div>
                            </form>

                            <form>
                                <div class="col-sm-4">
                                    <label for="amountLoan">Amount of Loan</label>
                                    <input type="number" class="form-control" id="amountLoan">
                                </div>
                                <div class="col-sm-4">
                                    <label for="interest">Interest</label>
                                    <input type="number" class="form-control" id="interest">
                                </div>
                                <div class="col-sm-4">
                                    <label for="totalLoans">Total Loans</label>
                                    <input type="number" class="form-control" id="totalLoan">
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-4">
                                    <label for="deduction">Deduction</label>
                                    <input type="number" class="form-control" id="deduction">
                                </div>
                                <div class="col-sm-4">
                                    <label for="balance">Balance</label>
                                    <input type="number" class="form-control" id="balance">
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" value="1" id="status" name="status" checked>
                                        Check if you want to deduct automatically in payroll.
                                      </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-loans">Save changes</button>
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade" id="editLoan" role="dialog" aria-labelledby="editLoan" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dimiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Edit Employee's Loan</h5>
                </div>
                <div class="modal-body loan">
                    <div class="row">
                        <div class="col-sm-12">
                            <form>
                                <input type="hidden" id="editId" name="editId">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputLoan">Loan Type</label>
                                         <select class="form-control" id="edit_loan_type" name="edit_loan_type" disabled>
                                          <option value="" selected>Loan Type</option>
                                          <option value="1">SSS LOAN</option>
                                          <option value="2">PAG-IBIG LOAN</option>
                                          <option value="3">COMPANY LOAN</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="loanType">Date Started</label>
                                        <div class="{{$errors->has('deduction_date') ? ' has-error' : '' }}">
                                        <input type="date" class="form-control" id="edit_date_deduction" name="edit_date_deduction">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="origTerms">Original Terms</label>
                                        <input type="number" class="form-control" id="edit_original_term">
                                    </div>
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="remTerms">Remaining Terms</label>
                                        <input type="number" class="form-control" id="edit_remaining_term">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="amountLoan">Amount of Loan</label>
                                        <input type="number" class="form-control" id="edit_amountLoan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="interest">Interest</label>
                                        <input type="number" class="form-control" id="edit_interest">
                                    </div>
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="totalLoans">Total Loans</label>
                                        <input type="number" class="form-control" id="edit_totalLoan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="deduction">Deduction</label>
                                        <input type="number" class="form-control" id="edit_deduction">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="balance">Balance</label>
                                        <input type="number" class="form-control" id="edit_balance">
                                    </div>
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" value="" id="EditStatus" name="EditStatus">
                                        Check if you want to deduct automatically in payroll.
                                      </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editLoanBtn">Save changes</button>
                </div>
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
                        <p>Are you sure, you want delete this loan?</p>
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
@endsection
=======
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Loans Management</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Employees</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Loans</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-base font-semibold text-slate-800">Loans for {{ $employee->full_name }}</h2>
            <p class="text-xs text-slate-500">Employee ID: {{ $employee->employee_id }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="/employee/account/{{ $employee->id }}" class="inline-flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-md text-xs font-medium transition-colors">
                <i class="fa fa-arrow-left mr-1.5"></i> Back to Account
            </a>
            <button type="button" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors" data-toggle="modal" data-target="#addLoansModal">
                <i class="fa fa-plus mr-1.5"></i> Add Loans
            </button>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2 border-b border-slate-200">Date Started</th>
                    <th class="px-4 py-2 border-b border-slate-200">Loan Type</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Loan Amount</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-center">Original Term</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-center">Remaining Term</th>
                    <th class="px-4 py-2 border-b border-slate-200">Note</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Deduction</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($employee_loan as $employee_loans)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500"><strong>{{$employee_loans->deduction_date}}</strong></td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-800">{{$employee_loans->loan_name}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm text-slate-500">₱{{number_format($employee_loans->loan_amount, 2)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-slate-500">{{$employee_loans->original_term}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-slate-500">{{$employee_loans->remaining_term}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$employee_loans->promissory_note}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm text-slate-500">₱{{number_format($employee_loans->deduction, 2)}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" data-toggle="modal" class="text-blue-600 hover:text-blue-900 mr-3" data-id="{{$employee_loans->id}}" data-target="#editLoan">Edit</button>
                        <button type="button" data-toggle="modal" data-id="{{$employee_loans->id}}" data-target=".bd-example-modal-sm" id="deleteLoan" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-sm text-slate-500">
                        <i class="fa fa-receipt text-3xl text-slate-300 mb-2 block"></i>
                        No loans recorded for this employee.
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
            <div class="modal-header">
                <h5 class="modal-title">Add Loan Information</h5>
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
                            <option value="4">ADVANCEMENT LOAN</option>
                            <option value="5">COOP LOAN</option>
                            <option value="6">INSURANCE LOAN</option>
                            <option value="7">EMERGENCY LOAN</option>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-loans">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{--editLoan Modal--}}
<div class="modal fade" id="editLoan" role="dialog" aria-labelledby="editLoan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee's Loan</h5>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editLoanBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{--delete check Modal--}}
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Loan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <p class="text-sm text-slate-600">Are you sure you want to delete this loan?</p>
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="btnYes">Yes</button>
            </div>
        </div>
    </div>
</div>
@endsection

>>>>>>> branch1
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/loan/loans.js"></script>
