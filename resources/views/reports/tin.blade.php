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
    		font-size: 13px;

    	}
    	td, th {
    		border: 1px solid;
    		text-align: center;
    	}
    	th {
    		padding-left: 10px;
    		padding-right: 10px;
    	} body {
        font-size: 12px;
        font-family: Raleway,sans-serif;
        color: #333;
    }
    </style>
</head>
<body>
<h4 style="text-align: center; font-weight: normal;">
    @if($tin_report->first())
        <strong>{{$tin_report->first()->departments->department_name}}</strong>
        <br>
        {{$tin_report->first()->departments->department_address}}
</h4>
<h3 style="text-align: center">Witholding Tax Report</h3>
<p class="text-center">For the month of {{ \Carbon\Carbon::parse($month)->format('F Y')}} </p>
@endif
<table class="employee">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Taxpayer's ID No.</th>
        <th>Gross Pay</th>
        <th>Non-Taxable Income</th>
        <th>Taxable Income</th>
        <th>W/Tax</th>

    </tr>
    {{--<tr>--}}
        {{--<th>Work Day</th>--}}
        {{--<th>Work Day</th>--}}
        {{--<th>Work Day</th>--}}
        {{--<th>Work Day</th>--}}
        {{--<th>Work Day</th>--}}
    {{--</tr>--}}
    </thead>
    <tbody>
    @foreach($tin_report as $tin_reports)
    <tr>
        <td>{{strtoupper($tin_reports->employee->full_name)}}</td>
        <td>{{$tin_reports->employee->tin_number}}</td>
        <td>{{number_format($tin_reports->total_gross,2)}}</td>
        <td>{{number_format($tin_reports->total_non_tax,2)}}</td>
        <td>{{number_format($tin_reports->total_gross - $tin_reports->total_non_tax,2)}}</td>
        <td>{{number_format($tin_reports->total_witholding,2)}}</td>
    </tr>
        @endforeach
    </tbody>
    <tbody class="total-border">
    <tr>
        <td class="bt-n"><strong></strong></td>
        <td class="bt-n"><strong>TOTAL</strong></td>
        <td><strong>{{number_format($monthly_gross_total,2)}}</strong></td>
        <td><strong>{{number_format($total_non_tax,2)}}</strong></td>
        <td><strong>{{number_format($total_taxable,2)}}</strong></td>
        <td><strong>{{number_format($total_witholding_tax,2)}}</strong></td>
    </tr>
    </tbody>

</table>
</body>
</html>