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
            /*text-align: right;*/
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
        .total-border td {
            border-top: 1px solid;
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
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
<h4 style="text-align: center; font-weight: normal;">
    @if($philhealth_report->first())
        <strong>{{$philhealth_report->first()->departments->department_name}}</strong>
        <br>
        {{$philhealth_report->first()->departments->department_address}}
</h4>
<h3 style="text-align: center">PhilHealth Contributions</h3>
<p class="text-center">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}} </p>
@endif
<table class="employee">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>PHIC No.</th>
        <th>Employee Share</th>
        <th>Employer Share</th>
    </tr>

    </thead>
    <tbody>
    @foreach($philhealth_report as  $philhealth_reports)
    <tr>
        <td>{{$philhealth_reports->employee->full_name}}</td>
        <td>{{$philhealth_reports->employee->philhealth_number}}</td>
        <td>{{number_format($philhealth_reports->total_phic,2)}}</td>
        <td>{{number_format($philhealth_reports->total_phic,2)}}</td>
    </tr>
        @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <td class="bt-n"><strong></strong></td>
        <td class="bt-n"><strong>TOTAL</strong></td>
        <td class="bt-n"><strong>{{number_format($total_phic_employee,2)}}</strong></td>
        <td class="bt-n"><strong>{{number_format($total_phic_employer,2)}}</strong></td>
        {{--<td class="bt-n"><strong>{{$total_hdmf_contribution}}</strong></td>--}}
    </tr>
    </tbody>

</table>
</body>
</html>