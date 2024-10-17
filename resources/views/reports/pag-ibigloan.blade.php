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
        /**, :after, :before {*/
        /*box-sizing: border-box;*/
        /*}*/
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
{{--@foreach($payslip as $payslips)--}}
<body>
<h3 class="text-center">MONTHLY REMITTANCE SCHEDULE FOR MULTIPURPOSE LOAN</h3>
@if($pagibig_loan_report->first())
<p class="employer pull-right">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}}<br>EMPLOYER TIN ID NO. :{{$pagibig_loan_report->first()->departments->employer_tin}}<br>ZIP CODE :{{$pagibig_loan_report->first()->departments->zip_code}}</p>
<p class="employer">Name :{{$pagibig_loan_report->first()->departments->department_name}}</p>
<p class="employer">Address :{{$pagibig_loan_report->first()->departments->department_address}}</p>
<p class="employer">Tel No : {{$pagibig_loan_report->first()->departments->tel_no}}</p>
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
            {{--<th rowspan="2">Use Code</th>--}}
            {{--<th rowspan="2">Remarks</th>--}}
        </tr>
        <tr>
            <th>Family Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pagibig_loan_report as $pagibig_loan_reports)
        <tr>
            <td>{{$pagibig_loan_reports->employee->tin_number}}</td>
            <td>{{$pagibig_loan_reports->employee->hdmf_number}}</td>
            <td>{{$pagibig_loan_reports->employee->birth_day}}</td>
            <td>{{$pagibig_loan_reports->employee->birth_day}}</td>
            <td>{{$pagibig_loan_reports->employee->employee_Lname}}</td>
            <td>{{$pagibig_loan_reports->employee->employee_Fname}}</td>
            <td>{{$pagibig_loan_reports->employee->employee_Mname}}</td>
            <td>{{number_format($pagibig_loan_reports->total_hdmf_loan,2)}}</td>
    @endforeach
        </tr>
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
        <td><strong>{{number_format($total_hdmf_loan,2)}}</strong></td>
    </tr>
    </tbody>
</table>
</body>
{{--@endforeach--}}
</html>