@extends('layouts.app')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading"><h1 class="text-center"><strong>Loan</strong></h1></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSSSLoan"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Loan </button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Loan Type</th>
                <th>Date Started</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Smith</td>
                    <td>SSS</td>
                    <td>5/23/2018</td>
                    <td>12,000</td>
                    <td><button class="btn btn-success" type="button" data-toggle="modal" data-target="#editLoan" aria-hidden="true">Edit</button></td>
                </tr>
            </tbody>

        </table>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputLoan">Loan Type</label>
                                         <select class="form-control"  >
                                          <option value="" selected>Loan Type</option>
                                          <option value="1">SSS LOAN</option>
                                          <option value="2">PAG-IBIG LOAN</option>
                                          <option value="3">COMPANY LOAN</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDep">Department</label>
                                        <select class="form-control" name="department" >
                                        <option value="" selected>Select Department</option>
                                          @foreach($department as $departments)
                                              <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                          @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputName">Employee Name</label>
                                        <select class="form-control" >
                                            <option value="" selected>Select Employee</option>
                                        </select>
                                    </div>
                                </div>
                              
                              
                            </form>
                         
                            <div class="col-sm-12">
                                <h4>Loan Info</h4>
                                <hr class="hr-em">
                            </div>
                            
                            <form>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="loanType">Date Started</label>
                                        <input type="date" class="form-control" id="edit_date_started">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="origTerms">Original Terms</label>
                                        <input type="number" class="form-control" id="edit_original_term">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="remTerms">Remaining Terms</label>
                                        <input type="number" class="form-control" id="edit_remaining_term">
                                    </div>
                                </div>
                            </form>


                            <form>
                                <div class="col-sm-4">
                                    <label for="amountLoan">Amount of Loan</label>
                                    <input type="number" class="form-control" id="edit_amountLoan">
                                </div>
                                <div class="col-sm-4">
                                    <label for="interest">Interest</label>
                                    <input type="number" class="form-control" id="edit_interest">
                                </div>
                                <div class="col-sm-4">
                                    <label for="totalLoans">Total Loans</label>
                                    <input type="number" class="form-control" id="edit_totalLoan">
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-4">
                                    <label for="deduction">Deduction</label>
                                    <input type="number" class="form-control" id="edit_deduction">
                                </div>
                                <div class="col-sm-4">
                                    <label for="balance">Balance</label>
                                    <input type="number" class="form-control" id="edit_balance">
                                </div>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" value="">
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
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addSSSLoan" tabindex="-1" role="dialog" aria-labelledby="addSSSLoan" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Employee's Loan</h5>
                </div>
                <div class="modal-body loan">
                    <div class="row">
                        <div class="col-sm-12">
                            <form>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputLoan">Loan Type</label>
                                         <select id="loan_type" class="form-control"  name="loan_type" >
                                          <option value="" selected>Loan Type</option>
                                          <option value="1">SSS LOAN</option>
                                          <option value="2">PAG-IBIG LOAN</option>
                                          <option value="3">COMPANY LOAN</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDep">Department</label>
                                        <select id="department" class="form-control" name="department" >
                                        <option value="" selected>Select Department</option>
                                          @foreach($department as $departments)
                                              <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                          @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputName">Employee Name</label>
                                        <select id="employee_name" class="form-control" name="employee_name" >
                                            <option value="" selected>Select Employee</option>
                                        </select>
                                    </div>
                                </div>
                              
                              
                            </form>
                         
                            <div class="col-sm-12">
                                <h4>Loan Info</h4>
                                <hr class="hr-em">
                            </div>
                            
                            <!-- <form>
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
                                        <input type="checkbox" value="">
                                        Check if you want to deduct automatically in payroll.
                                      </label>
                                    </div>
                                </div>
                            </form> -->
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
                                    <label for="amountLoan">Amount of Loan</label>
                                    <input type="number" class="form-control" id="amountLoan">
                                </div>
                            </form>
                            <form>
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" value="1" id="status" checked>
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

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/loan/loans.js"></script>