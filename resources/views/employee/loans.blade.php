@extends('layouts.app')
@section('content')

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
                                             <option value="6">INSURANCE LOAN</option>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/loan/loans.js"></script>
