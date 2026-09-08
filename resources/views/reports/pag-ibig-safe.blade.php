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
            display: table;
            border-collapse: separate;
            border-spacing: 2px;
            border-color: grey;
        }
        @page {
            margin: 10px;
        }
        body {
            font-family: Raleway,sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #333;
        }
        p {
            font-size: 12px;
            margin: 0 0 0px;
        }
        table {
            border-collapse: collapse;
            font-size: 11px;
            width: 100%;

        }
        td, th {
            border: 1px solid;
            text-align: center;
            padding: 5px;
            display: table-cell;
            vertical-align: inherit;
            text-align: center !important;
        }
        th {
            vertical-align: text-top;
        }
        .employee {
            width: 100%;
        }
        .total-border td {
            border-top: 1px solid;
        }
        .employee td {
            border: none;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .employer {
            text-transform: uppercase;
            font-weight: bold;
            font-style: italic;
        }
        .pull-right {
            float: right;
            display: block;
            text-align: right !important;
        }
    </style>
</head>
<body>
<h3 class="text-center">MONTHLY REMITTANCE SCHEDULE FOR PAG-IBIG SAFE LOAN</h3>
@if($pagibig_safe_loan_report->first())
<p class="employer pull-right">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}}<br>EMPLOYER TIN ID NO. :{{$pagibig_safe_loan_report->first()->departments->employer_tin}}<br>ZIP CODE :{{$pagibig_safe_loan_report->first()->departments->zip_code}}</p>
<p class="employer">Name :{{$pagibig_safe_loan_report->first()->departments->department_name}}</p>
<p class="employer">Address :{{$pagibig_safe_loan_report->first()->departments->department_address}}</p>
<p class="employer">Tel No : {{$pagibig_safe_loan_report->first()->departments->tel_no}}</p>
@endif
<table class="employee">
    <thead>
        <tr>
            <th rowspan="2">TIN I.D Number</th>
            <th rowspan="2">HDMF No.</th>
            <th rowspan="2">Promissory Note</th>
            <th rowspan="2">Date of Birth</th>
            <th colspan="3">NAME OF BORROWERS</th>
            <th rowspan="2">Monthly Amortization</th>
        </tr>
        <tr>
            <th>Family Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pagibig_safe_loan_report as $reports)
        <tr>
            <td>{{$reports->employee->tin_number}}</td>
            <td>{{$reports->employee->hdmf_number}}</td>
            <td>{{$reports->employee->birth_day}}</td>
            <td>{{$reports->employee->birth_day}}</td>
            <td>{{$reports->employee->employee_Lname}}</td>
            <td>{{$reports->employee->employee_Fname}}</td>
            <td>{{$reports->employee->employee_Mname}}</td>
            <td>{{number_format($reports->total_other_loan, 2)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <td class="bt-n"></td>
        <td class="bt-n"></td>
        <td class="bt-n"></td>
        <td class="bt-n"></td>
        <td class="bt-n"></td>
        <td class="bt-n"></td>
        <td class="bt-n"><strong>TOTAL</strong></td>
        <td><strong>{{number_format($total_pagibig_safe_loan, 2)}}</strong></td>
    </tr>
    </tbody>
</table>
</body>
</html>
