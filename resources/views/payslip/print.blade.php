<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Payroll Report</title>

    <style>
    @page {
        margin: 12px 24px;
    }
    body {
        padding: 0;
        margin: 0;
        font-size: 9.5px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #222;
        line-height: 1.15;
    }
    .payslip {
        margin: 0;
        padding: 0;
    }
    .dept-title {
        text-align: center;
        font-weight: bold;
        font-size: 12.5px;
        margin: 0 0 1px 0;
        padding: 0;
        line-height: 1.2;
    }
    .dept-sub {
        font-size: 8.5px;
        text-align: center;
        margin: 0 0 5px 0;
        padding: 0;
        line-height: 1.25;
        color: #444;
    }
    .pull-right {
        text-align: right;
    }
    .employee {
        width: 100%;
        border-collapse: collapse;
    }
    .employee td, .employee th {
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 0;
        padding-right: 0;
    }
    .text-muted {
        color: #6c757d !important;
    }
    td.pl-1, th.pl-1, .employee td.pl-1, .employee th.pl-1, .pl-1 {
        padding-left: 15px !important;
        border-left: 1px solid #dee2e6; 
    }
    td.pl-0, th.pl-0, .employee td.pl-0, .employee th.pl-0, .pl-0 {
        text-align: center;
    }
    td.pr-1, th.pr-1, .employee td.pr-1, .employee th.pr-1, .pr-1 {
        text-align: right;
        padding-right: 25px !important;
    }
    td.bt-1, th.bt-1, .employee td.bt-1, .employee th.bt-1, .bt-1 {
        border-top: 1px solid #dee2e6 !important;
        padding-top: 3px !important;
        padding-bottom: 3px !important;
    }
    td.bt-2, th.bt-2, .employee td.bt-2, .employee th.bt-2, .bt-2 {
        border-top: 1.5px solid #dee2e6 !important;
        padding-top: 3px !important;
        padding-bottom: 3px !important;
    }
    .slip-table {
        border-top: .5px solid #dee2e6 !important;
    }
    .th-border {
        border-top: .5px solid #dee2e6 !important;
        border-bottom: .5px solid #dee2e6 !important;
    }
    th {
        padding: 3px 0px;
        font-size: 9.5px;
    }
    td {
        overflow-wrap: break-word;
        font-size: 9.5px;
    }
    .page-break {
        page-break-after: always;
        clear: both;
    }
    .divider {
        border-top: 1px dashed #777;
        margin: 10px 0 8px 0;
        clear: both;
    }
</style>
</head>
<body>
@foreach($payslip as $payslips)
    <div class="payslip">
        <div style="width: 100%;">
            <p class="dept-title">{{$payslips->departments->department_name}}</p>
            <p class="dept-sub">
                {{$payslips->departments->department_address}}
                <br>
                Payroll for the period from: {{ \Carbon\Carbon::parse($payslips->date_from)->format('jS \\of F Y')}} to {{ \Carbon\Carbon::parse($payslips->date_to)->format('jS \\of F Y')}}
            </p>

            <table class="employee">
                <tr>
                    <td>Name: <strong> {{$payslips->employee->full_name}}</strong></td>
                    <td class="pull-right">Payroll #:{{$payslips->payroll_number}}</td>
                </tr>
                <tr>
                    <td>Employee ID: {{$payslips->employee->employee_id}}</td>
                </tr>
            </table>
            <table class="employee">
                <colgroup>
                    <col style="width: 25%;">
                    <col style="width: 10%;">
                    <col style="width: 18%;">
                    <col style="width: 32%;">
                    <col style="width: 15%;">
                </colgroup>
                <thead class="th-border">
                    <tr>
                        <th style="text-align: left;">Basic Pay</th>
                        <th style="text-align: center;">Days/Hrs</th>
                        <th class="pr-1">Amount</th>
                        <th class="pl-1">Deductions</th>
                        <th class="pull-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="slip-table">
                    <tr>
                        <td>Std. Work Days</td>
                        @if($payslips->work_days)
                        <td class="pl-0">{{$payslips->work_days}}</td>
                        @else
                        <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->work_days_amount)
                        <td class="pull-right pr-1">{{number_format($payslips->work_days_amount,2)}}</td>
                        @else
                        <td class="pull-right pr-1">0.00</td>
                        @endif

                        <td class="pl-1">Witholding Tax</td>
                        @if($payslips->witholding_tax)
                        <td class="pull-right">{{number_format($payslips->witholding_tax,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Overtime</td>
                        @if($payslips->overtime)
                            <td class="pl-0">{{$payslips->overtime}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->overtime_amount)
                        <td class="pull-right pr-1">{{number_format($payslips->overtime_amount,2)}}</td>
                        @else
                        <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">SSS</td>
                        @if($payslips->sss_contribution)
                        <td class="pull-right">{{number_format($payslips->sss_contribution,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                            <td colspan="2" class="pull-right pr-1"></td>
                        <td class="pl-1">Provident fund(SSS)</td>
                        @if($payslips->provident_fund)
                            <td class="pull-right">{{number_format($payslips->provident_fund,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Rest Days</td>
                        @if($payslips->rest_special)
                            <td class="pl-0">{{$payslips->rest_special}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->rest_special_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->rest_special_amount,2)}}</td>
                        @else
                            <td class="pull-right pr-1">0.00</td>
                        @endif

                        <td class="pl-1">HDMF</td>
                        @if($payslips->hdmf_contribution)
                            <td class="pull-right">{{number_format($payslips->hdmf_contribution,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Restday(OT)</td>
                        @if($payslips->exc_rest_special)
                            <td class="pl-0">{{$payslips->exc_rest_special}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->exc_rest_special_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->exc_rest_special_amount,2)}}</td>
                        @else
                            <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">Phil. Health</td>
                        @if($payslips->phic_contribution)
                            <td class="pull-right">{{number_format($payslips->phic_contribution,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Excess Hrs</td>
                        @if($payslips->ext_reg_hrs)
                            <td class="pl-0">{{$payslips->ext_reg_hrs}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->ext_reg_hrs_ammount)
                        <td class="pull-right pr-1">{{number_format($payslips->ext_reg_hrs_ammount,2)}}</td>
                        @else
                        <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">Insurance</td>
                        @if($payslips->insurance)
                            <td class="pull-right">{{number_format($payslips->insurance,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Night Diff</td>
                        @if($payslips->night_diff)
                            <td class="pl-0">{{$payslips->night_diff}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->night_diff_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->night_diff_amount,2)}}</td>
                        @else
                            <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1"></td>
                        <td class="pull-right"></td>
                    </tr>
                    <tr>
                        <td>Night Diff Restday</td>
                        @if($payslips->night_diff_restday)
                            <td class="pl-0">{{$payslips->night_diff_restday}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->night_diff_restday_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->night_diff_restday_amount,2)}}</td>
                        @else
                            <td class="pull-right pr-1">0.00</td>
                        @endif
                        
                        <td class="text-muted pl-1"><small> LOANS</small></td>
                        <td class="pull-right"></td>
                    </tr>
                    <tr>
                        <td>Regular Holidays</td>
                        @if($payslips->regular_holiday_day || $payslips->regular_holiday_day_minimum)
                            <td class="pl-0">{{$payslips->regular_holiday_day + $payslips->regular_holiday_day_minimum}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->regular_holiday_day_amount || $payslips->regular_holiday_day_minimum_amount)
                        <td class="pull-right pr-1">{{number_format($payslips->regular_holiday_day_amount + $payslips->regular_holiday_day_minimum_amount,2)}}</td>
                        @else
                        <td class="pull-right pr-1">0.00</td>
                        @endif

                        <td class="pl-1">SSS(salary)</td>
                        @if($payslips->sss_loan)
                        <td class="pull-right">{{number_format($payslips->sss_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif

                    </tr>
                    <tr><td>Special Holidays</td>
                        @if($payslips->special_holiday_day || $payslips->special_holiday_day_minimum)
                            <td class="pl-0">{{$payslips->special_holiday_day + $payslips->special_holiday_day_minimum}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->special_holiday_day_amount || $payslips->special_holiday_day_minimum_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->special_holiday_day_amount + $payslips->special_holiday_day_minimum_amount,2)}}</td>
                        @else
                            <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">SSS(calamity)</td>
                        @if($payslips->sss_calamity_loan)
                        <td class="pull-right">{{number_format($payslips->sss_calamity_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif

                    </tr>
                    <tr>
                        <td>Leave</td>
                        @if($payslips->sick_leave)
                            <td class="pl-0">{{$payslips->sick_leave + $payslips->vacation_leave}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->sick_leave_amount)
                        <td class="pull-right pr-1">{{number_format($payslips->sick_leave_amount + $payslips->vacation_leave_amount,2)}}</td>
                        @else
                        <td class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">HMDF</td>
                        @if($payslips->hdmf_loan)
                        <td class="pull-right">{{number_format($payslips->hdmf_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Other N-Taxable</td>
                        @if($payslips->cola_amount || $payslips->non_tax_other)
                        <td colspan="2" class="pull-right pr-1">{{number_format($payslips->non_tax_other + $payslips->cola_amount,2)}}</td>
                        @else
                        <td colspan="2" class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">HDMF(calamity)</td>
                        @if($payslips->hdmf_calamity_loan)
                        <td class="pull-right">{{number_format($payslips->hdmf_calamity_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="pull-right pr-1"></td>
                        <td class="pl-1">Pag-IBIG Safe</td>
                        @if($payslips->other_loan)
                            <td class="pull-right">{{number_format($payslips->other_loan,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" class="pull-right pr-1"></td>
                        <td class="pl-1">SSS(emergency)</td>
                        @if($payslips->sss_emergency_loan)
                            <td class="pull-right">{{number_format($payslips->sss_emergency_loan,2)}}</td>
                        @else
                            <td class="pull-right">0.00</td>
                        @endif
                    </tr>

                    <tr>
                        <td class="bt-1"><strong> Gross Pay</strong></td>
                        <td colspan="2" class="pull-right bt-1 pr-1">
                            <strong> {{number_format($payslips->gross_pay,2)}}</strong>
                        </td>
                        <td class="pl-1 bt-1">
                            <strong> Total Deductions</strong>
                        </td>
                        <td class="pull-right bt-1">
                            <strong> {{number_format($payslips->hdmf_loan + $payslips->hdmf_calamity_loan + $payslips->sss_loan + $payslips->other_loan + $payslips->sss_contribution + $payslips->phic_contribution + $payslips->hdmf_contribution + $payslips->insurance + $payslips->sss_emergency_loan + $payslips->witholding_tax,2)}}</strong>
                        </td>

                    </tr>
                </tbody>
            </table>
            <table class="employee">
                <tbody>
                    <tr>
                        <td class="bt-2 pull-right" style="font-weight: bold;"> Net Pay</td>
                        <td class="bt-2 pull-right" style="font-weight: bold;">{{number_format($payslips->net_pay,2)}}</td>
                    </tr>
                </tbody>

            </table>

            <table class="employee" style="margin-top: 3px;">
                <tr>
                    <td rowspan="3" style="width: 10%; vertical-align: top;">Paid By:</td>
                    <td style="width: 8%;">ATM</td>
                    <td style="width: 10%;">____</td>
                    <td></td>
                    <td class="pull-right" style="vertical-align: top;">Received By: (Signature)</td>
                </tr>
                <tr>
                    <td>CASH</td>
                    <td>____</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>CHK</td>
                    <td>____</td>
                    <td></td>
                    <td class="pull-right" style="vertical-align: bottom; padding-top: 10px;"><u>{{$payslips->employee->full_name}}</u></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td class="pull-right"><small>Signature over Printed Name</small></td>
                </tr>
            </table>
        </div>
    </div>

    @if($loop->iteration % 2 == 1 && !$loop->last)
        <div class="divider"></div>
    @elseif($loop->iteration % 2 == 0 && !$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
</body>

</html>