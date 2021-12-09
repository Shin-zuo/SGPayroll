@extends('layouts.app')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Loans</div>
        <div class="panel-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addLoansModal" title="View" data-content="" >
                <span class="glyphicon glyphicon-plus"></span>
                Add Loan Type
            </button>
            <hr>
            <table class="table">
                <thead>

                <tr>
                    <th>Loan ID</th>
                    <th>Loan Type Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($loan as $loans)
                <tr>
                    <td><strong>{{$loans->loan_id}}</strong></td>
                    <td>{{$loans->loan_type_name}}</td>
                    <td>-</td>
                </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    
    {{--addLoans Modal--}}
    <div class="modal fade" tabindex="-1" id="addLoansModal" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Loans</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                        <div class="form-group error">
                            <label class="col-sm-3 control-label">Loan Type :</label>
                            <div class="col-sm-7">
                                        <input type="text" class="form-control  has-error" id="loan_type_name" name="loan_type_name">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_addLoanType">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/loan/loans.js"></script>