<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 5px; border: 1px solid #ddd; }
        th { background-color: #f5f5f5; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .header-title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 5px; }
        .company-name { font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="company-name">SGPayroll</div>
    <div class="header-title">PAYSLIP</div>
    <p class="text-center">Period: {{ $payroll->date_from }} to {{ $payroll->date_to }}</p>

    <table>
        <tr>
            <th>Employee Name</th>
            <td>{{ $payroll->employee ? $payroll->employee->full_name : 'Unknown' }}</td>
            <th>Department</th>
            <td>{{ $payroll->department }}</td>
        </tr>
        <tr>
            <th>Payroll Number</th>
            <td>{{ $payroll->payroll_number }}</td>
            <th>Basic Pay</th>
            <td>{{ number_format($payroll->work_days_amount, 2) }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="2" class="text-center">EARNINGS</th>
            <th colspan="2" class="text-center">DEDUCTIONS</th>
        </tr>
        <tr>
            <td>Basic Pay</td><td class="text-right">{{ number_format($payroll->work_days_amount, 2) }}</td>
            <td>Withholding Tax</td><td class="text-right">{{ number_format($payroll->witholding_tax, 2) }}</td>
        </tr>
        <tr>
            <td>Overtime</td><td class="text-right">{{ number_format($payroll->overtime_amount, 2) }}</td>
            <td>SSS Contribution</td><td class="text-right">{{ number_format($payroll->sss_contribution, 2) }}</td>
        </tr>
        <tr>
            <td>Holiday Pay</td><td class="text-right">{{ number_format($payroll->regular_holiday_amount + $payroll->special_holiday_amount, 2) }}</td>
            <td>PhilHealth Contribution</td><td class="text-right">{{ number_format($payroll->phic_contribution, 2) }}</td>
        </tr>
        <tr>
            <td>Night Diff</td><td class="text-right">{{ number_format($payroll->night_diff_amount, 2) }}</td>
            <td>Pag-IBIG Contribution</td><td class="text-right">{{ number_format($payroll->hdmf_contribution, 2) }}</td>
        </tr>
        <tr>
            <td>Leave Pay</td><td class="text-right">{{ number_format($payroll->sick_leave_amount + $payroll->vacation_leave_amount, 2) }}</td>
            <td>Loans</td><td class="text-right">{{ number_format($payroll->sss_loan + $payroll->sss_calamity_loan + $payroll->hdmf_loan + $payroll->hdmf_calamity_loan + $payroll->company_loan + $payroll->other_loan + $payroll->sss_emergency_loan, 2) }}</td>
        </tr>
        <tr>
            <td>Other Pay (COLA, etc)</td><td class="text-right">{{ number_format($payroll->cola_amount + $payroll->non_tax_other, 2) }}</td>
            <td>Other Deductions</td><td class="text-right">{{ number_format($payroll->rent + $payroll->insurance, 2) }}</td>
        </tr>
        <tr>
            <th class="text-right">Total Gross Pay</th>
            <th class="text-right">{{ number_format($payroll->gross_pay, 2) }}</th>
            <th class="text-right">Total Deductions</th>
            <th class="text-right">{{ number_format($payroll->gross_pay - $payroll->net_pay, 2) }}</th>
        </tr>
        <tr>
            <th colspan="3" class="text-right" style="font-size:16px;">NET PAY</th>
            <th class="text-right" style="font-size:16px;">{{ number_format($payroll->net_pay, 2) }}</th>
        </tr>
    </table>

    <p class="text-center" style="margin-top: 50px; color: #777;">This is a system generated payslip.</p>
</body>
</html>
