<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Report</title>
    <style>
        table {
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;

        }
        th {
            border: 1px solid;
            text-align: center;
        }
        td {
            padding: 5px;
            text-align: center;
        }
        th {
            padding: 5px;
        }
        body {
            font-size: 12px;
            font-family: Raleway,sans-serif;
            color: #333;
        }
        .pull-right {
            text-align: right;
        }
        .employee {
            width: 100%;
        }

        .text-muted {
            color: #6c757d !important;
        }
        .pl-1 {
            padding-left: 15px;
        }
        hr {
            display: block;
            border: 0;
            border-top: 1px solid #a2a2a2;
            height: 0;
        }
        td:first-child {
            text-align: left !important;
        }
        .text-center {
            text-align: center;
        }
        h3, h4 {
            margin: 5px;
        }
        .total-border td {
            border-top: 1px solid;
        }
        .total-border td {
            border-top: 1px solid;
        }
        .bt-n {
            border-top: none !important;
        }
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
<h4 style="text-align: center; font-weight: normal;">
    @if($sss_loan_report->first())
        <strong>{{$sss_loan_report->first()->departments->department_name}}</strong>
        <br>
        {{$sss_loan_report->first()->departments->department_address}}
</h4>
<h3 style="text-align: center">Social Security System (SALARY LOAN)</h3>
<p class="text-center">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}}  </p>
@endif
<table class="employee">
    <thead>
    <tr>
        <th>SSS Number</th>
        <th>Employee Name</th>
        <th>Loan Type</th>
        <th>Loan Amount</th>
        <th>Penalty Amount</th>
        <th >Total</th>

    </tr>
    </thead>
    <tbody>
    @foreach($sss_loan_report as $sss_loan_reports)
        <tr>
            <td>{{$sss_loan_reports->employee->sss_number}}</td>
            <td>{{$sss_loan_reports->employee->full_name}}</td>
            <td>S</td>
            <td>{{number_format($sss_loan_reports->total_sss_loan,2)}}</td>
            <td>0.00</td>
            <td>{{number_format($sss_loan_reports->total_sss_loan,2)}}</td>

        </tr>
    @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <tD><strong>TOTAL NUMBER OF RECORD:</strong></tD>
        <td><strong>{{$sss_loan_report->count()}}</strong></td>
        <td></td>
        <td></td>
        <td><strong>TOTAL</strong></td>
        <td><strong>{{number_format($total_sss_loan,2)}}</strong></td>
    </tr>
    </tbody>
</table>
<h3 style="text-align: center">Social Security System (CALAMITY LOAN)</h3>
<table class="employee">
    <thead>
    <tr>
        <th>SSS Number</th>
        <th>Employee Name</th>
        <th>Loan Type</th>
        <th>Loan Amount</th>
        <th>Penalty Amount</th>
        <th >Total</th>


    </tr>
    </thead>
    <tbody>
    @foreach($sss_calamity_loan_report as $sss_calamity_loan_reports)
    @if($sss_calamity_loan_reports->total_sss_calamity_loan > 0)
        <tr>
            <td>{{$sss_calamity_loan_reports->employee->sss_number}}</td>
            <td>{{$sss_calamity_loan_reports->employee->full_name}}</td>
            <td>C</td>
            <td>{{number_format($sss_calamity_loan_reports->total_sss_calamity_loan,2)}}</td>
            <td>0.00</td>
            <td>{{number_format($sss_calamity_loan_reports->total_sss_calamity_loan,2)}}</td>

        </tr>
        @endif
    @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <tD><strong>TOTAL NUMBER OF RECORD:</strong></tD>
        <td><strong>{{$sss_calamity_loan_report->count()}}</strong></td>
        <td></td>
        <td></td>
        <td><strong>TOTAL</strong></td>
        <td><strong>{{number_format($total_sss_calamity_loan,2)}}</strong></td>


    </tr>
    </tbody>
</table>
</body>
</html>