@extends('layouts.app')
@section('content')

<div class="panel panel-default" style="background-color:#f7e8f0">
    <div class="panel-heading text-center" style="background-color:#f1c6de"><h1><strong>Reports</strong></h1></div>
    <div class="panel-body">
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" action="/reports/view-report">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-2">Select Report :</label>
                    <div class="col-md-4">
                        <select id="report_type" class="form-control" name="report_type">
                            <option value="Payroll">PAYROLL</option>
                            <option value="Sss">SSS</option>
                            <option value="Pag-IBIG">Pag-IBIG</option>
                            <option value="WITHOLDING TAX">WITHOLDING TAX</option>
                            <option value="PHILHEALTH">PHILHEALTH </option>
                            <option value="SSS LOANS">SSS LOANS</option>
                            <option value="Pag-IBIG LOANS">Pag-IBIG LOANS</option>
                            <option value="13 MONTH">THIRTEEN MONTH</option>
                            <option value="ALPHA LIST">ALPHA LIST</option>
                            <option value="ALPHA LIST (MONTHLY)">ALPHA LIST (MONTHLY)</option>
                            <option value="EMPLOYEE INFORMATION">EMPLOYEE INFORMATION</option>
                        </select>
                    </div>
                    <label class="control-label col-md-2">Select Department :</label>
                    <div class="col-md-4">
                        <select id="" class="form-control" name="department">
                            @foreach($department as $departments)
                            <option value="{{$departments}}">{{strtoupper($departments)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div id='month'>
                        <label class="control-label col-md-2">Month:</label>
                        <div class="col-md-4">
                            <input type="month" class="form-control" name="monthRep" id="monthRep" value="{{date('Y-m')}}">
                        </div>
                    </div>
                    <div id="quarter" style="display:none">
                        <label class="control-label col-md-2">Quarter :</label>
                        <div class="col-md-4">
                            <select class="form-control" id="quarterYear" name="quarterYear">
                                <option value="1">First Half - From November 26 last year to May 25 current year</option>
                                <option value="2">Second Half - From May 26 current year to November 25 current year</option>
                            </select>
                        </div>
                    </div>
                    <div id="payroll_no">
                        <label class="control-label col-md-2">Payroll :</label>
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
                </div>
                <div class="row" style="margin-right: 45%">
                        <button type="submit" class="pull-right btn btn-primary"> Generate Report</button>
                </div>
              
            </form>
        </div>
    </div>

</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/report/report.js"></script>