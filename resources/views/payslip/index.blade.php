@extends('layouts.app')
@section('content')
<div class="panel panel-default" style="background-color:#f7e8f0">
    <div class="panel-heading text-center" style="background-color:#f1c6de"><h1><strong>Payslip</strong></h1></div>
    <div class="panel-body">
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" action="/payslip/view-payslip">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="search">Department :</label>
                    <div class="col-sm-3{{ $errors->has('department') ? ' has-error' : '' }}">
                        <select id="department" class="form-control" name="department" >
                            <option value="">-----SELECT DEPARTMENT-----</option>
                            @foreach($department as $departments)
                            <option value="{{strtoupper($departments->department_name)}}">{{strtoupper($departments->department_name)}} - {{strtoupper($departments->department_code)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="control-label col-sm-1">Date</label>
                    <div class="col-md-3">
                        <input type="month" class="form-control" id="date_payslip" name="date_payslip" value="{{date('Y-m')}}">
                    </div>
                    <label class="control-label col-sm-1">Payroll</label>
                    <div class="col-md-2">
                        <select class="form-control" id="payroll_number" name="payroll_number">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class=" col-sm-3 text-center">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="print_all" name="print_all" value="1"><strong> Print All</strong>
                        </label>
                    </div>
                    

                    <label for="inputBP" class="col-sm-3 control-label">Employee ID:</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="employee_id" name="employee_id">
                        </select>
                    </div>
                </div>
                <button type="submit" class="pull-right btn btn-primary" formtarget="_blank"> Generate</button>
            </form>


        </div>
    </div>

</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/payslip/payslip.js"></script>