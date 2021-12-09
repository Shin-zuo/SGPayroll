<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Payroll Report</title>

    <style>
    body {
        padding: 0rem 2rem;
        font-size: 11px;
        font-family: Raleway,sans-serif;
        color: #333;
    }
    .payslip {
        margin-top: 2px;
        margin-bottom: 15px;
    }
    .pull-right {
        text-align: right;
        /*float:left;*/
    }
    .employee {
        width: 100%;
    }
    .text-muted {
        color: #6c757d !important;
    }
    .pl-1 {
        padding-left: 30px;
        border-left: 1px solid #dee2e6; 
    }
    .pl-0 {
        padding-left: 60px;
    }
    .pr-1 {
        padding-right: 30px !important;
    }
    .bt-1 {
        border-top: 1px solid #dee2e6 !important;
        padding-top: 5px;
    }
    .bt-2 {
        border-top: 2px solid #dee2e6 !important;
        padding-top: 5px;
    }
    .slip-table {
        border-top: .5px solid #dee2e6 !important;
        padding: 10px 0px;
    }
    .th-border {
        border-top: .5px solid #dee2e6 !important;
    }
    th {
        padding: 5px 0px;
    }
    td {
        overflow-wrap: break-word;
    }
    @page {
      margin: 10px;
  }
</style>
    <!-- <style>
    table {
      display: table;
      border-collapse: separate;
      border-spacing: 2px;
      border-color: grey;
  }

  body {
      font-family: Raleway,sans-serif;
      font-size: 12px;
      line-height: 1.3;
  }
  p {
      text-align: center;
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
      padding: 0;
      display: table-cell;
      vertical-align: inherit;
  }
  th {
      padding-left: 10px;
      padding-right: 10px;
  }
  /**, :after, :before {*/
      /*box-sizing: border-box;*/
      /*}*/
      .employee {
          width: 100%;
      }
      .employee td {
          border: none;
          text-align: left;
      }

    }
</style> -->
</head>
<body>
@foreach($payslip as $payslips)
    <div class="payslip">
        <div style="width: 100%;">
            <p style="text-align: center;">{{$payslips->departments->department_name}}</p>
            <p style="font-size: 11px; text-align: center;">
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
                <thead class="th-border">
                    <tr>
                        <th>Basic Pay</th>
                        <th class="pl-0">Days/Hrs</th>
                        <th class="pull-right pr-1">Amount</th>
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
                        <td>Night Differential</td>
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
                        <td class="text-muted pl-1"><small> LOANS</small></td>
                        <td class="pull-right"></td>
                    </tr>
                    <tr>
                        <td>Regular Holidays</td>
                        @if($payslips->regular_holiday_day)
                            <td class="pl-0">{{$payslips->regular_holiday_day}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->regular_holiday_day_amount)
                        <td class="pull-right pr-1">{{number_format($payslips->regular_holiday_day_amount,2)}}</td>
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
                        @if($payslips->special_holiday_day)
                            <td class="pl-0">{{$payslips->special_holiday_day}}</td>
                        @else
                            <td class="pl-0">0.00</td>
                        @endif
                        @if($payslips->special_holiday_day_amount)
                            <td class="pull-right pr-1">{{number_format($payslips->special_holiday_day_amount,2)}}</td>
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
                        <td class="pl-1">Advance</td>
                        @if($payslips->company_loan)
                        <td class="pull-right">{{number_format($payslips->company_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Thirteen Month Pay</td>
                        @if($payslips->thirteen_month)
                            <td colspan="2" class="pull-right pr-1">{{$payslips->thirteen_month}}</td>
                        @else
                            <td colspan="2" class="pull-right pr-1">0.00</td>
                        @endif
                        <td class="pl-1">Coop.</td>
                        @if($payslips->other_loan)
                        <td class="pull-right">{{number_format($payslips->other_loan,2)}}</td>
                        @else
                        <td class="pull-right">0.00</td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                            <td colspan="2" class="pull-right pr-1"></td>
                        <td class="pl-1">Other</td>
                        @if($payslips->rent)
                            <td class="pull-right">{{number_format($payslips->rent,2)}}</td>
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
                            <strong> {{number_format($payslips->company_loan + $payslips->hdmf_loan + $payslips->sss_loan + $payslips->other_loan + $payslips->sss_contribution + $payslips->phic_contribution + $payslips->hdmf_contribution + $payslips->insurance + $payslips->rent,2)}}</strong>
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

            <table class="employee">
                <tr>
                    <td rowspan="3">Paid By:</td>
                    <td>ATM</td>
                    <td>____</td>
                    <td></td>
                    <td class="pull-right">Received By: (Signature)</td>
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
                    <td class="pull-right"><u>{{$payslips->employee->full_name}}.</u></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td class="pull-right"><small>Signature over Printed Name</small></td>
                </tr>
            </table>
        </div>
    </div>


@endforeach
</body>

</html>