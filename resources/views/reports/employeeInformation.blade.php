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
            font-size: 11px;

        }
        td, th {
            border: 1px solid;
            text-align: center;
            padding: 5px;
        }
        td {
            overflow-wrap: break-word;
        }
        body {
            font-size: 12px;
            font-family: Raleway,sans-serif;
            color: #333;
        }
        .pull-right {
            text-align: right;
            /*float:left;*/
        }
        .text-center {
            text-align: center;
        }
        .employee {
            width: 100%;
        }
        .text-muted {
            color: #6c757d !important;
        }
        .employee {
            width: 100%;
        }
        .col-4 {
            width: 33.33333333%;
            display: block;
            float: left;
        }
        h2 {
            margin: 5px 0px;
        }
        @page {
            margin: 15px;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
<h4 style="text-align: center; font-weight: normal;">
    @if($employee_information->first())
        <strong>{{$employee_information->first()->departments->department_name}}</strong>
        <br>
        {{$employee_information->first()->departments->department_address}}
</h4>
<h3 style="text-align: center">Employee Information Sheet</h3>
{{--<p class="text-center">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}} </p>--}}
@endif
<table class="employee">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Date of Birth</th>
        <th>Status</th>
        <th>Address</th>

    </tr>

    </thead>
    <tbody>
    @foreach($employee_information as  $employee_info)
        <tr>
            <td>{{strtoupper($employee_info->employee->full_name)}}</td>
            <td>{{\Carbon\Carbon::parse($employee_info->employee->birth_day)->format('m/d/Y')}}</td>
            <td>{{$employee_info->employee->status}}</td>
            <td><strong>{{$employee_info->employee->address}}</strong></td>

        </tr>
    @endforeach
    </tbody>


</table>

<div class="page_break">
    <h3 style="text-align: center">INACTIVE EMPLOYEE</h3>
    <table class="employee">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Date of Birth</th>
            <th>Status</th>
            <th>Address</th>

        </tr>

        </thead>
        <tbody>
        @foreach($inactive_employees as  $inactive_employee)
            <tr>
                <td>{{strtoupper($inactive_employee->employee->full_name)}}</td>
                <td>{{\Carbon\Carbon::parse($inactive_employee->employee->birth_day)->format('m/d/Y')}}</td>
                <td>{{$inactive_employee->employee->status}}</td>
                <td><strong>{{$inactive_employee->employee->address}}</strong></td>

            </tr>
        @endforeach
        </tbody>


    </table>
</div>

</body>
</html>