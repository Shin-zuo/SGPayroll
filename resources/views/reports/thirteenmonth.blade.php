<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="13month"
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
    	}
    	th {
    		padding-left: 80px;
    		padding-right: 80px;
    	} body {
        font-size: 12px;
        font-family: Raleway,sans-serif;
        color: #333;
    }
    </style>
</head>
<body>
<h4 style="text-align: center; font-weight: normal;">
    @if($thirteen_month->first())
        <strong>{{$thirteen_month->first()->department}}</strong>
        {{--{{$thirteen_month->first()->departments->department_address}}--}}

</h4>
<p class="text-center">From the month of <strong>{{\Carbon\Carbon::parse($monthFrom)->format('d F Y')}}</strong> to <strong>{{\Carbon\Carbon::parse($monthTo)->format('d F Y')}}</strong></p>
@endif
<table class="employee">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Total Basic Pay</th>
        <th>Thirteenth Month Pay</th>
    </tr>
    </thead>
    <tbody>
    @foreach($thirteen_month as  $thirteen_month_report)
        @php
            $rest_day = $thirteen_month_report->rest_special_hours/8;
            $rest_day_total = $rest_day *  $thirteen_month_report->employee->basic_pay;
        @endphp
        <tr>
            <td>{{strtoupper($thirteen_month_report->employee->full_name)}}</td>
            <td>{{number_format($thirteen_month_report->basic_pay + $thirteen_month_report->leave_amount)}}</td>
            <td>{{number_format(($thirteen_month_report->basic_pay + $thirteen_month_report->leave_amount)/12,2)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <td class="bt-n"><strong>TOTAL</strong></td>
        <td class="bt-n"><strong>{{number_format($total_thirteen,2)}}</strong></td>
        <td class="bt-n"><strong>{{number_format($total_thirteen/12,2)}}</strong></td>
    </tr>
    </tbody>

</table>
</body>
</html>