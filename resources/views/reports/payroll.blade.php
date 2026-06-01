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

        td,
        th {
            border: 1px solid;
            text-align: center;
            padding: 5px;
        }

        td {
            overflow-wrap: break-word;
        }

        body {
            font-size: 12px;
            font-family: Raleway, sans-serif;
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

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>

    @if ($payroll_report->first())
        <div class="col-4">
            <strong> {{ $payroll_report->first()->departments->department_name }}</strong>
            <br>
            {{ $payroll_report->first()->departments->department_address }}
        </div>
        <div class="col-4 text-center">
            <h2>Payroll Register</h2>

            Payroll for the period from:
            {{ \Carbon\Carbon::parse($payroll_report->first()->date_from)->format('jS \\of F Y') }} to
            {{ \Carbon\Carbon::parse($payroll_report->first()->date_to)->format('jS \\of F Y') }}
    @endif
    </div>
    <div class="col-4 pull-right">
        <strong> SEMI-MONTHLY</strong>
    </div>


    <table class="employee" style="margin-top: 70px;">
        <thead>
            <tr>
                <th rowspan="3" colspan="3">Name</th>
                <th colspan="6">Basic Pay</th>
                <th colspan="2">Other Pay</th>
                <th rowspan="3">Gross Pay</th>
                <th rowspan="3">Wtax</th>
                <th colspan="8">Contributions</th>
                {{--<th rowspan="3">Insurance</th>--}}
                <th rowspan="3">Insurance</th>
                <th colspan="6">Loans</th>
                <th rowspan="3">Net Pay</th>
                {{--<th rowspan="3">Adv.</th>--}}

            </tr>

            <tr>
                <th rowspan="2">Work Day</th>
                <th rowspan="2">OT Pay</th>
                <th rowspan="2">Excess Hrs</th>
                <th rowspan="2">Holiday</th>
                <th rowspan="2">Vacation Leave</th>
                <th rowspan="2">Sick Leave</th>
                <th rowspan="2">Other Taxable Pay</th>
                <th rowspan="2">Other NT Pay</th>
                <th colspan="4">Employee</th>
                <th colspan="4">Employer</th>
                <th rowspan="2">SSS (salary)</th>
                <th rowspan="2">SSS (calamity)</th>
                <th rowspan="2">Pag-IBIG</th>
                <th rowspan="2">HDMF (calamity)</th>
                <th rowspan="2">Advance</th>
                <th rowspan="2">Coop</th>

                {{--<th rowspan="2">Coop</th>--}}

            </tr>
            <tr>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>

            </tr>

        </thead>
        <tbody>
            {{ $total_sss = 0 }}
            {{ $grossEr = 0 }}
            @foreach ($payroll_report as $payroll_reports)
                <tr>
                    <td colspan="3">{{ strtoupper($payroll_reports->employee->full_name) }}</td>
                    <td>{{ number_format($payroll_reports->work_days_amount, 2) }}</td>
                    <td>{{ number_format($payroll_reports->overtime_amount, 2) }}</td>
                    <td>{{ number_format($payroll_reports->ext_reg_hrs_ammount, 2) }}</td>
                    <td>{{ number_format($payroll_reports->regular_holiday_day_amount, 2) }}</td>
                    <td>{{ number_format($payroll_reports->sick_leave_amount, 2) }}</td>
                    <td>{{ number_format($payroll_reports->vacation_leave_amount, 2) }}</td>
                    <td>0.00</td>
                    <td>{{ number_format($payroll_reports->cola_amount + $payroll_reports->non_tax_other, 2) }}</td>
                    <td>{{ number_format($payroll_reports->gross_pay, 2) }}</td>
                    <td>{{ number_format($payroll_reports->witholding_tax, 2) }}</td>
                    <td>{{ number_format($payroll_reports->sss_contribution, 2) }}</td>
                    <td>{{ number_format($payroll_reports->provident_fund, 2) }}</td>
                    <td>{{ number_format($payroll_reports->phic_contribution, 2) }}</td>
                    <td>{{ number_format($payroll_reports->hdmf_contribution, 2) }}</td>
                    @if ($payroll_reports->endMonth == 'true')
                        @php
                        $grosspay_month =
                        \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_reports->employee_code)->where('monthly_record','=',$payroll_reports->monthly_record)->where('year','=',$payroll_reports->year)->get();
                        $total_gross = $grosspay_month->sum('gross_pay');
                        $first_gross =
                        \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_reports->employee_code)->where('monthly_record','=',$payroll_reports->monthly_record)->where('year','=',$payroll_reports->year)->where('endMonth','!=','true')->get();
                        $total_first_gross = $first_gross->sum('gross_pay');
                        $employer_share = \SGpayroll\Sss_Table::whereRaw('? between range_from and range_to',
                        [round($total_gross, 2)])->get();
                        if ($payroll_reports->employee->sss_status == 1)
                        {
                        $employer_sss = ($employer_share[0]['sss_er']+ $employer_share[0]['ec_er']) -
                        ($total_first_gross*0.1);
                        }
                        else
                        {
                        $employer_sss =0;
                        }
                        if($employer_sss <= 0)
                        {
                            $employer_sss =0;
                        }

                        $total_sss += $employer_sss;
                        @endphp
                        @if ($payroll_reports->employee->sss_status == 1)
                            <td>{{ number_format($employer_sss, 2) }}</td>

                        @else
                            <td>0.00</td>
                        @endif
                    @else
                        @if ($payroll_reports->employee->sss_status == 1)
                            <td>{{ number_format($payroll_reports->gross_pay * 0.1, 2) }}</td>
                            {{ $grossEr += $payroll_reports->gross_pay }}
                        @else
                            <td>0.00</td>
                        @endif

                    @endif
                    <td>{{ number_format((($payroll_reports->provident_fund/0.05)* 0.1), 2) }}</td>
                    <td>{{ number_format($payroll_reports->phic_contribution, 2) }}</td>
                    <td>{{ number_format($payroll_reports->hdmf_contribution, 2) }}</td>
                    <td>{{ number_format($payroll_reports->insurance, 2) }}</td>
                    <td>{{ number_format($payroll_reports->sss_loan, 2) }}</td>
                    <td>{{ number_format($payroll_reports->sss_calamity_loan, 2) }}</td>
                    <td>{{ number_format($payroll_reports->hdmf_loan, 2) }}</td>
                    <td>{{ number_format($payroll_reports->hdmf_calamity_loan,2) }}</td>
                    <td>{{ number_format($payroll_reports->company_loan, 2) }}</td>
                    <td>{{ number_format($payroll_reports->other_loan, 2) }}</td>
                    <td>{{ number_format($payroll_reports->net_pay, 2) }}</td>
                </tr>

            @endforeach

            <tr>
                <th colspan="3">Total</th>
                <td><strong>{{ number_format($payroll_report->sum('work_days_amount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('overtime_amount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('ext_reg_hrs_ammount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('regular_holiday_day_amount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('sick_leave_amount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('vacation_leave_amount'), 2) }}</strong></td>
                <td><strong>0.00</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('cola_amount'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('gross_pay'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('witholding_tax'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('sss_contribution'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('provident_fund'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('phic_contribution'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('hdmf_contribution'), 2) }}</strong></td>
                @if ($payroll_reports->endMonth == 'true')
                    <td><strong>{{ number_format($total_sss, 2) }}</strong> </td>
                @else
                    <td>{{ number_format($grossEr * 0.1, 2) }}</td>
                @endif
                <td><strong>{{ number_format((($payroll_report->sum('provident_fund')/0.05)* 0.1), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('phic_contribution'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('hdmf_contribution'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('insurance'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('sss_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('sss_calamity_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('hdmf_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('hdmf_calamity_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('company_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('other_loan'), 2) }}</strong></td>
                <td><strong>{{ number_format($payroll_report->sum('net_pay'), 2) }}</strong></td>
            </tr>

        </tbody>

    </table>
    @if ($payroll_report->first()->department != 'MPI-SENIOR WORKER')
        <div class="page_break">
            <div class="text-center">
                <strong>
                    <h3> ADMIN EMPLOYEE TOTAL SUMMARY</h3>
                </strong>
            </div>
            <table class="employee" style="margin-top: 20px;">
                <thead>
                <tr>
                <th rowspan="3" colspan="3">Name</th>
                <th colspan="6">Basic Pay</th>
                <th colspan="2">Other Pay</th>
                <th rowspan="3">Gross Pay</th>
                <th rowspan="3">Wtax</th>
                <th colspan="8">Contributions</th>
                {{--<th rowspan="3">Insurance</th>--}}
                <th rowspan="3">Insurance</th>
                <th colspan="6">Loans</th>
                <th rowspan="3">Net Pay</th>
                {{--<th rowspan="3">Adv.</th>--}}

            </tr>

            <tr>
                <th rowspan="2">Work Day</th>
                <th rowspan="2">OT Pay</th>
                <th rowspan="2">Excess Hrs</th>
                <th rowspan="2">Holiday</th>
                <th rowspan="2">Vacation Leave</th>
                <th rowspan="2">Sick Leave</th>
                <th rowspan="2">Other Taxable Pay</th>
                <th rowspan="2">Other NT Pay</th>
                <th colspan="4">Employee</th>
                <th colspan="4">Employer</th>
                <th rowspan="2">SSS (salary)</th>
                <th rowspan="2">SSS (calamity)</th>
                <th rowspan="2">Pag-IBIG</th>
                <th rowspan="2">HDMF (calamity)</th>
                <th rowspan="2">Advance</th>
                <th rowspan="2">Coop</th>

                {{--<th rowspan="2">Coop</th>--}}

            </tr>
            <tr>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>

            </tr>


                </thead>
                <tbody>
                    {{ $total_sss = 0 }}
                    {{ $grossEr = 0 }}
                    @foreach ($payroll_report_admins as $payroll_report_admin)
                        <tr>
                            <td colspan="3">{{ strtoupper($payroll_report_admin->employee->full_name) }}</td>
                            <td>{{ number_format($payroll_report_admin->work_days_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->overtime_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->ext_reg_hrs_ammount, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->regular_holiday_day_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->sick_leave_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->vacation_leave_amount, 2) }}</td>
                            <td>0.00</td>
                            <td>{{ number_format($payroll_report_admin->cola_amount + $payroll_report_admin->non_tax_other, 2) }}
                            </td>
                            <td>{{ number_format($payroll_report_admin->gross_pay, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->witholding_tax, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->sss_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->provident_fund, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->phic_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->hdmf_contribution, 2) }}</td>
                            @if ($payroll_report_admin->endMonth == 'true')
                                @php
                                $grosspay_month =
                                \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_report_admin->employee_code)->where('monthly_record','=',$payroll_report_admin->monthly_record)->where('year','=',$payroll_report_admin->year)->get();
                                $total_gross = $grosspay_month->sum('gross_pay');
                                $first_gross =
                                \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_report_admin->employee_code)->where('monthly_record','=',$payroll_report_admin->monthly_record)->where('year','=',$payroll_report_admin->year)->where('endMonth','!=','true')->get();
                                $total_first_gross = $first_gross->sum('gross_pay');
                                $employer_share = \SGpayroll\Sss_Table::whereRaw('? between range_from and range_to',
                                [round($total_gross, 2)])->get();
                                $employer_sss = ($employer_share[0]['sss_er']+ $employer_share[0]['ec_er']) -
                                ($total_first_gross* 0.1);
                               
                                if($employer_sss <= 0)
                        {
                            $employer_sss =0;
                        }
                        $total_sss += $employer_sss;
                                @endphp
                                @if ($payroll_report_admin->employee->sss_status == 1)
                                    <td>{{ number_format($employer_sss, 2) }}</td>
                                @else
                                    <td>0.00</td>
                                @endif

                            @else
                                @if ($payroll_report_admin->employee->sss_status == 1)
                                    <td>{{ number_format($payroll_report_admin->gross_pay * 0.1, 2) }}</td>
                                    {{ $grossEr += $payroll_report_admin->gross_pay }}
                                @else
                                    <td>0.00</td>
                                @endif
                            @endif
                            <td>{{ number_format((($payroll_report_admin->provident_fund/.05)* 0.1), 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->phic_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->hdmf_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->insurance, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->sss_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->sss_calamity_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->hdmf_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->hdmf_calamity_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->company_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->rent, 2) }}</td>
                            <td>{{ number_format($payroll_report_admin->net_pay, 2) }}</td>
                        </tr>

                    @endforeach
                    @if ($payroll_report_admins->count() > 0)
                        <tr>
                            <th colspan="3">Total</th>
                            <td><strong>{{ number_format($payroll_report_admins->sum('work_days_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('overtime_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('ext_reg_hrs_ammount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('regular_holiday_day_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('sick_leave_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('vacation_leave_amount'), 2) }}</strong>
                            </td>
                            <td><strong>0</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('cola_amount'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('gross_pay'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('witholding_tax'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('sss_contribution'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report->sum('provident_fund'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('phic_contribution'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('hdmf_contribution'), 2) }}</strong>
                            </td>
                            @if ($payroll_report_admin->endMonth == 'true')
                                <td><strong>{{ number_format($total_sss, 2) }}</strong> </td>
                            @else
                                <td>{{ number_format($payroll_report_admins->sum('gross_pay') * 0.1, 2) }}</td>
                            @endif
                            <td><strong>{{ number_format((($payroll_report_admins->sum('provident_fund')/0.05)*0.1), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('phic_contribution'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('hdmf_contribution'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('insurance'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('sss_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('sss_calamity_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('hdmf_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('hdmf_calamity_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('company_loan'), 2) }}</strong>
                            </td>

                            <td><strong>{{ number_format($payroll_report_admins->sum('other_loan')) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_admins->sum('net_pay'), 2) }}</strong></td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>

        <div class="page_break">
            <div class="text-center">
                <strong>
                    <h3> COST EMPLOYEE TOTAL SUMMARY</h3>
                </strong>
            </div>
            <table class="employee" style="margin-top: 20px;">
                <thead>
                <tr>
                <th rowspan="3" colspan="3">Name</th>
                <th colspan="6">Basic Pay</th>
                <th colspan="2">Other Pay</th>
                <th rowspan="3">Gross Pay</th>
                <th rowspan="3">Wtax</th>
                <th colspan="8">Contributions</th>
                {{--<th rowspan="3">Insurance</th>--}}
                <th rowspan="3">Insurance</th>
                <th colspan="6">Loans</th>
                <th rowspan="3">Net Pay</th>
                {{--<th rowspan="3">Adv.</th>--}}


            </tr>

            <tr>
                <th rowspan="2">Work Day</th>
                <th rowspan="2">OT Pay</th>
                <th rowspan="2">Excess Hrs</th>
                <th rowspan="2">Holiday</th>
                <th rowspan="2">Vacation Leave</th>
                <th rowspan="2">Sick Leave</th>
                <th rowspan="2">Other Taxable Pay</th>
                <th rowspan="2">Other NT Pay</th>
                <th colspan="4">Employee</th>
                <th colspan="4">Employer</th>
                <th rowspan="2">SSS (salary)</th>
                <th rowspan="2">SSS (calamity)</th>
                <th rowspan="2">Pag-IBIG</th>
                <th rowspan="2">HDMF (calamity)</th>
                <th rowspan="2">Advance</th>
                <th rowspan="2">Coop</th>

                {{--<th rowspan="2">Coop</th>--}}
            </tr>

            <tr>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>
                <th>SSS</th>
                <th>Provident Fund</th>
                <th>PHIC</th>
                <th>HDMF</th>

            </tr>

                </thead>
                <tbody>

                    {{ $total_sss = 0 }}
                    {{ $grossEr = 0 }}
                    @foreach ($payroll_report_costs as $payroll_report_cost)
                        <tr>
                            <td colspan="3">{{ strtoupper($payroll_report_cost->employee->full_name) }}</td>
                            <td>{{ number_format($payroll_report_cost->work_days_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->overtime_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->ext_reg_hrs_ammount, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->regular_holiday_day_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->sick_leave_amount, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->vacation_leave_amount, 2) }}</td>
                            <td>0.00</td>
                            <td>{{ number_format($payroll_report_cost->cola_amount + $payroll_report_cost->non_tax_other, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->gross_pay, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->witholding_tax, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->sss_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->provident_fund, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->phic_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->hdmf_contribution, 2) }}</td>

                            @if ($payroll_report_cost->endMonth == 'true')
                                @php
                                $grosspay_month =
                                \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_report_cost->employee_code)->where('monthly_record','=',$payroll_report_cost->monthly_record)->where('year','=',$payroll_report_cost->year)->get();
                                $total_gross = $grosspay_month->sum('gross_pay');
                                $first_gross =
                                \SGpayroll\Employee_Payrolls::where('employee_code','=',$payroll_report_cost->employee_code)->where('monthly_record','=',$payroll_report_cost->monthly_record)->where('year','=',$payroll_report_cost->year)->where('endMonth','!=','true')->get();
                                $total_first_gross = $first_gross->sum('gross_pay');
                                $employer_share = \SGpayroll\Sss_Table::whereRaw('? between range_from and range_to',
                                [round($total_gross, 2)])->get();
                                $employer_sss = ($employer_share[0]['sss_er']+ $employer_share[0]['ec_er']) -
                                ($total_first_gross*0.1);
                                
                                if($employer_sss <= 0)
                        {
                            $employer_sss = 0;
                        }
                        $total_sss += $employer_sss;
                                @endphp

                                @if ($payroll_report_cost->employee->sss_status == 1)
                                    <td>{{number_format($employer_sss, 2)}}</td>
                                @else
                                    <td>0.00</td>
                                @endif

                            @else
                                @if ($payroll_report_cost->employee->sss_status == 1)
                                    <td>{{ number_format($payroll_report_cost->gross_pay * 0.1, 2) }}</td>
                                    {{ $grossEr += $payroll_report_cost->gross_pay }}
                                @else
                                    <td>0.00</td>
                                @endif
                            @endif
                            <td>{{ number_format((($payroll_report_cost->provident_fund/.05)* 0.1), 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->phic_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->hdmf_contribution, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->insurance, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->sss_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->sss_calamity_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->hdmf_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->hdmf_calamity_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->company_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->other_loan, 2) }}</td>
                            <td>{{ number_format($payroll_report_cost->net_pay, 2) }}</td>
                        </tr>

                    @endforeach
                    @if ($payroll_report_costs->count() > 0)
                        <tr>
                            <th colspan="3">Total</th>
                            <td><strong>{{ number_format($payroll_report_costs->sum('work_days_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('overtime_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('ext_reg_hrs_ammount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('regular_holiday_day_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('sick_leave_amount'), 2) }}</strong>
                            </td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('vacation_leave_amount'), 2) }}</strong></td>
                            <td><strong>0.00</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('cola_amount'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('gross_pay'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('witholding_tax'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('sss_contribution'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('provident_fund'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('phic_contribution'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('hdmf_contribution'), 2) }}</strong>
                            </td>

                            @if ($payroll_report_cost->endMonth == 'true' AND $payroll_report_cost->employee->sss_status == 1)
                                <td><strong>{{ number_format($total_sss, 2) }}</strong> </td>
                            @elseif ($payroll_report_cost->employee->sss_status == 0)
                                <td>0.00</td>
                            @else
                                <td>{{ number_format($payroll_report_costs->sum('gross_pay') * 0.1, 2) }}</td>
                            @endif
                            <td><strong>{{ number_format((($payroll_report_costs->sum('provident_fund')/0.05)* 0.1), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('phic_contribution'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('hdmf_contribution'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('insurance'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('sss_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('sss_company_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('hdmf_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('hdmf_calamity_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('company_loan'), 2) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('other_loan')) }}</strong></td>
                            <td><strong>{{ number_format($payroll_report_costs->sum('net_pay'), 2) }}</strong></td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    @endif

 
</body>

</html>
