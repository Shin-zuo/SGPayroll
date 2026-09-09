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
    @if(isset($department) && $department)
        <strong>{{$department->department_name}}</strong>
        <br>
        {{$department->department_address}}
    @elseif(isset($departmentName) && $departmentName)
        <strong>{{$departmentName}}</strong>
    @elseif($employee_information->first() && $employee_information->first()->departments)
        <strong>{{$employee_information->first()->departments->department_name}}</strong>
        <br>
        {{$employee_information->first()->departments->department_address}}
    @elseif($employee_information->first())
        <strong>{{$employee_information->first()->department}}</strong>
    @endif
</h4>
<h3 style="text-align: center">Employee Information Sheet</h3>

<table class="employee">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Date Hired</th>
        <th>Date of Birth</th>
        <th>Contact No.</th>
        <th>TIN ID</th>
        <th>SSS No.</th>
        <th>Pag-ibig No.</th>
        <th>Philhealth No.</th>
        <th>UB Account No.</th>
        <th>Address</th>
    </tr>

    </thead>
    <tbody>
    @forelse($employee_information as $employee_info)
        @php
            $emp = isset($employee_info->employee) ? $employee_info->employee : $employee_info;
        @endphp
        <tr>
            <td>{{strtoupper($emp->full_name)}}</td>
            <td>{{$emp->date_hired ? \Carbon\Carbon::parse($emp->date_hired)->format('m/d/Y') : '-'}}</td>
            <td>{{$emp->birth_day ? \Carbon\Carbon::parse($emp->birth_day)->format('m/d/Y') : '-'}}</td>
            <td>{{$emp->contactNo ?: '-'}}</td>
            <td>{{$emp->tin_number ?: '-'}}</td>
            <td>{{$emp->sss_number ?: '-'}}</td>
            <td>{{$emp->hdmf_number ?: '-'}}</td>
            <td>{{$emp->philhealth_number ?: '-'}}</td>
            <td>{{$emp->ucpb_number ?: '-'}}</td>
            <td><strong>{{$emp->address ?: '-'}}</strong></td>
        </tr>
    @empty
        <tr>
            <td colspan="10" style="text-align: center; padding: 10px; color: #888;">No active employees found.</td>
        </tr>
    @endforelse
    </tbody>


</table>

<div class="page_break">
    <h3 style="text-align: center">INACTIVE EMPLOYEE</h3>
    <table class="employee">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Date Hired</th>
            <th>Date of Birth</th>
            <th>Contact No.</th>
            <th>TIN ID</th>
            <th>SSS No.</th>
            <th>Pag-ibig No.</th>
            <th>Philhealth No.</th>
            <th>UB Account No.</th>
            <th>Address</th>
        </tr>

        </thead>
        <tbody>
        @forelse($inactive_employees as $inactive_employee)
            @php
                $inEmp = isset($inactive_employee->employee) ? $inactive_employee->employee : $inactive_employee;
            @endphp
            <tr>
                <td>{{strtoupper($inEmp->full_name)}}</td>
                <td>{{$inEmp->date_hired ? \Carbon\Carbon::parse($inEmp->date_hired)->format('m/d/Y') : '-'}}</td>
                <td>{{$inEmp->birth_day ? \Carbon\Carbon::parse($inEmp->birth_day)->format('m/d/Y') : '-'}}</td>
                <td>{{$inEmp->contactNo ?: '-'}}</td>
                <td>{{$inEmp->tin_number ?: '-'}}</td>
                <td>{{$inEmp->sss_number ?: '-'}}</td>
                <td>{{$inEmp->hdmf_number ?: '-'}}</td>
                <td>{{$inEmp->philhealth_number ?: '-'}}</td>
                <td>{{$inEmp->ucpb_number ?: '-'}}</td>
                <td><strong>{{$inEmp->address ?: '-'}}</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 10px; color: #888;">No inactive employees found.</td>
            </tr>
        @endforelse
        </tbody>


    </table>
</div>

</body>
</html>