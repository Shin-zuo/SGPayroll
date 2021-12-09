<?php

namespace SGpayroll\Http\Controllers\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use SGpayroll\Department;
use SGpayroll\Employee_Payrolls;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Sss_Table;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $department = Employee_Payrolls::select('department')->orderBy('department')->get()->pluck('department')->unique();
        return view('reports.index', compact('department'));
    }
    // View Report
    public function viewReport(Request $request)
    {
        // Payroll Reports
        $customPaper = array(0,0,612.00, 1208.00);
        if ($request['report_type'] == 'Payroll') {
            $this->validate($request, [
                'department' => 'required'
            ]);
            $payroll_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('payroll_number', $request['payroll_number'])
                ->where('employee_payrolls.department', $request['department'])
                ->get(); 
            $payroll_report_admins = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.categories', '=', 'true')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('payroll_number', $request['payroll_number'])
                ->where('employee_payrolls.department', $request['department'])
                ->get();
            $payroll_report_costs = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.categories', '!=', 'true')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('payroll_number', $request['payroll_number'])
                ->where('employee_payrolls.department', $request['department'])
                ->get();
            $data = [
                'payroll_report' => $payroll_report,
                'payroll_report_admins' => $payroll_report_admins,
                'payroll_report_costs' => $payroll_report_costs
            ];
            $pdf = PDF::loadView('reports.payroll', $data)->setPaper($customPaper, 'landscape');
            return $pdf->stream('payroll-reports.pdf');
        }
        // SSS Reports
        if ($request['report_type'] == 'Sss') {
            $sss_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employees.sss_status', '=', '1')
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.gross_pay) as total_gross,SUM(employee_payrolls.sss_contribution) as total_sss,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $total_sss_er = 0;
            $total_ec_er = 0;
            $total_sss_ee = 0;
            $total_provident_er = 0;
            $total_provident_ee = 0;
            foreach ($sss_report as $sss_total) {
                $total_sss_er += $sss_total->sss()->sss_er;
                $total_ec_er += $sss_total->sss()->ec_er;
                $total_sss_ee += $sss_total->sss()->sss_ee;
                $total_provident_er += $sss_total->sss()->provident_fund*0.085;
                $total_provident_ee += $sss_total->sss()->provident_fund*0.045;
            }
            $data = [
                'sss_report' => $sss_report,
                'total_sss_er' => $total_sss_er,
                'total_ec_er' => $total_ec_er,
                'total_sss_ee' => $total_sss_ee,
                'total_provident_er' => $total_provident_er,
                'total_provident_ee' => $total_provident_ee,
                'month' => $request['monthRep'],
            ];

            $pdf = PDF::loadView('reports.sss', $data);
            return $pdf->stream('sss-reports.pdf');
        }
        // HDMF Reports
        if ($request['report_type'] == 'Pag-IBIG') {
            $hdmf_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employees.pag_ibig_contribution', '=', '1')
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.gross_pay) as total_gross,SUM(employee_payrolls.hdmf_contribution) as total_hdmf,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $total_employee_hdmf = 0;
            $total_employer_hdmf = 0;
            $total_hdmf_contribution = 0;
            foreach ($hdmf_report as $hdmf_reports) {
                $total_employee_hdmf += $hdmf_reports->total_hdmf;
                $total_employer_hdmf += $hdmf_reports->total_hdmf;
                $total_hdmf_contribution  += $hdmf_reports->total_hdmf;
            }
            $data = [
                'hdmf_report' => $hdmf_report,
                'total_employee_hdmf' => $total_employee_hdmf,
                'total_employer_hdmf' => $total_employer_hdmf,
                'total_hdmf_contribution' => $total_hdmf_contribution * 2,
                'month' => $request['monthRep']
            ];
            $pdf = PDF::loadView('reports.pagibig', $data);
            return $pdf->stream('hdmf-reports.pdf');
        }
        // Witholding Tax Reports
        if ($request['report_type'] == 'WITHOLDING TAX') {
            $tin_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.gross_pay) as total_gross,SUM(employee_payrolls.non_tax_other) as total_non_tax,SUM(employee_payrolls.witholding_tax) as total_witholding,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $monthly_gross_total = 0;
            $total_non_taxable = 0;
            $total_witholding_tax = 0;
            foreach ($tin_report as $tin_reports) {
                $monthly_gross_total += $tin_reports->total_gross;
                $total_non_taxable += $tin_reports->total_non_tax;
                $total_witholding_tax += $tin_reports->total_witholding;
            }
            $data = [
                'tin_report' => $tin_report,
                'monthly_gross_total' => $monthly_gross_total,
                'total_non_tax' => $total_non_taxable,
                'total_taxable' => $monthly_gross_total - $total_non_taxable,
                'total_witholding_tax' => $total_witholding_tax,
                'month' => $request['monthRep']
            ];
            $pdf = PDF::loadView('reports.tin', $data);
            return $pdf->stream('tin-reports.pdf');
        }
        // Philhealth Reports
        if ($request['report_type'] == 'PHILHEALTH') {
            $philhealth_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employees.phic_status', '=', '1')
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.gross_pay) as total_gross,SUM(employee_payrolls.phic_contribution) as total_phic,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $total_phic_employee = 0;
            $total_phic_employer = 0;
            foreach ($philhealth_report as  $philhealth_reports) {
                $total_phic_employee += $philhealth_reports->total_phic;
                $total_phic_employer += $philhealth_reports->total_phic;
            }
            $data = [
                'philhealth_report' => $philhealth_report,
                'total_phic_employee' => $total_phic_employee,
                'total_phic_employer' => $total_phic_employee,
                'month' => $request['monthRep']
            ];
            $pdf = PDF::loadView('reports.philhealth', $data);
            return $pdf->stream('philhealth-reports.pdf');
        }
        // SSS Loans Reports
        if ($request['report_type'] == 'SSS LOANS') {
            $sss_loan_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.sss_loan','>',0)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.sss_loan) as total_sss_loan,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $sss_calamity_loan_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.sss_calamity_loan','>',0)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.sss_calamity_loan) as total_sss_calamity_loan,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $total_sss_loan = 0;
            $total_sss_calamity_loan = 0;

            foreach ($sss_loan_report as $sss_loan_reports) {
                $total_sss_loan += $sss_loan_reports->total_sss_loan;
            }
            foreach ($sss_calamity_loan_report as $sss_calamity_loan_reports) {
                $total_sss_calamity_loan += $sss_calamity_loan_reports->total_sss_calamity_loan;
            }
            $data = [
                'sss_loan_report' => $sss_loan_report->where('total_sss_loan', '>', 0),
                'sss_calamity_loan_report' => $sss_calamity_loan_report->where('total_sss_calamity_loan', '>', 0),
                'total_sss_loan' => $total_sss_loan,
                'total_sss_calamity_loan' => $total_sss_calamity_loan,
                'month' => $request['monthRep']
            ];
            $pdf = PDF::loadView('reports.loan', $data)->setPaper('Legal', 'landscape');
            return $pdf->stream('loan-reports.pdf');
            //            return view('reports.loan');  
        }
        // HDMF Loans Reports
        if ($request['report_type'] == 'Pag-IBIG LOANS') {
            $pagibig_loan_report = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employee_payrolls.monthly_record', Carbon::parse($request['monthRep'])->month)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', DB::raw('SUM(employee_payrolls.hdmf_loan) as total_hdmf_loan,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department')
                ->get();
            $total_hdmf_loan = 0;
            foreach ($pagibig_loan_report as $pagibig_loan_reports) {
                $total_hdmf_loan += $pagibig_loan_reports->total_hdmf_loan;
            }

            $data = [
                'pagibig_loan_report' => $pagibig_loan_report->where('total_hdmf_loan', '>', 0),
                'total_hdmf_loan' => $total_hdmf_loan,
                'month' => $request['monthRep']
            ];
            $pdf = PDF::loadView('reports.pag-ibigloan', $data)->setPaper('Legal', 'landscape');
            return $pdf->stream('pag-ibig-loan-reports.pdf');
        }
        // Thirteen Month Reports
        if ($request['report_type'] == '13 MONTH') {
            if (!empty($request['quarterYear']) && $request['quarterYear'] == 1) {
                // Set range for 1st quarter
                $strFromFirstQuarter = Carbon::now()->subYear(1)->year.'-11-26';
                $strToFirstQuarter = Carbon::now()->year.'-05-25';
                // Get the records base on range
                $thirteen_month = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->whereBetween('employee_payrolls.date_to', [Carbon::parse($strFromFirstQuarter),Carbon::parse($strToFirstQuarter)])
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department', 'employees.custom_thirteen')
                ->get();
            } elseif (!empty($request['quarterYear']) && $request['quarterYear'] == 2) {
                // Set range for 2nd quarter
                $strFromFirstQuarter = Carbon::now()->year.'-05-26';
                $strToFirstQuarter = Carbon::now()->year.'-11-25';
    
                // Get the records base on range
                $thirteen_month = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->whereBetween('employee_payrolls.date_to', [Carbon::parse($strFromFirstQuarter),Carbon::parse($strToFirstQuarter)])
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,employee_payrolls.department'))
                ->groupBy('employee_code', 'employee_payrolls.department', 'employees.custom_thirteen')
                ->get();
            }
            $total_thirteen_month = 0;
            foreach ($thirteen_month as $thirteen) {
                $total_thirteen_month += $thirteen->basic_pay  + $thirteen->leave_amount; 
            }
            $data = [
                'thirteen_month' => $thirteen_month,
                'total_thirteen' => $total_thirteen_month,
                'monthFrom' => $strFromFirstQuarter,
                'monthTo' => $strToFirstQuarter
            ];
            $pdf = PDF::loadView('reports.thirteenmonth', $data)->setPaper('Legal');
            return $pdf->stream('thirteenmonth.pdf');
        }
        // Alpha List Reports
        if ($request['report_type'] == 'ALPHA LIST') {
            $active_employee = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.employee_status', 1)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.tin_number', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.regular_holiday_day_minimum_amount) as regular_holiday_minimum_amount,SUM(employee_payrolls.special_holiday_day_minimum_amount) as special_holiday_minimum_amount,SUM(employee_payrolls.thirteen_month) as thirteen_month,SUM(employee_payrolls.regular_holiday_day_minimum_amount) as regular_holiday_minimum,SUM(employee_payrolls.special_holiday_day_minimum_amount) as special_holiday_minimum,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.thirteen_month) as thirteen_month,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.vacation_leave_amount) as vacation_leave_amount,SUM(employee_payrolls.sick_leave_amount) as sick_leave_amount,SUM(employee_payrolls.sss_contribution) as annual_sss,SUM(employee_payrolls.phic_contribution) as annual_phic,SUM(employee_payrolls.non_tax_other) as annual_non_tax_other,SUM(employee_payrolls.cola_amount) as annual_cola_amount,SUM(employee_payrolls.gross_pay) as annual_work_days_amount,SUM(employee_payrolls.witholding_tax) as annual_witholding_tax,SUM(employee_payrolls.hdmf_contribution) as annual_hdmf,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,SUM(employee_payrolls.regular_holiday_day_amount) as regular_holiday_amount,SUM(employee_payrolls.special_holiday_day_amount) as special_holiday_amount,SUM(employee_payrolls.overtime_amount) as overtime_amount,SUM(employee_payrolls.night_diff_amount) as night_diff_amount,employee_payrolls.department,employees.salary_status'))
                ->groupBy('employee_code', 'employees.tin_number', 'employee_payrolls.department', 'employees.custom_thirteen','employees.salary_status')
                ->get();
            $inactive_employee = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.employee_status', 2)
                ->where('employee_payrolls.year', Carbon::parse($request['monthRep'])->year)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.tin_number', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.regular_holiday_day_minimum_amount) as regular_holiday_minimum_amount,SUM(employee_payrolls.special_holiday_day_minimum_amount) as special_holiday_minimum_amount,SUM(employee_payrolls.thirteen_month) as thirteen_month,SUM(employee_payrolls.regular_holiday_day_minimum_amount) as regular_holiday_minimum,SUM(employee_payrolls.special_holiday_day_minimum_amount) as special_holiday_minimum,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.thirteen_month) as thirteen_month,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.vacation_leave_amount) as vacation_leave_amount,SUM(employee_payrolls.sick_leave_amount) as sick_leave_amount,SUM(employee_payrolls.sss_contribution) as annual_sss,SUM(employee_payrolls.phic_contribution) as annual_phic,SUM(employee_payrolls.non_tax_other) as annual_non_tax_other,SUM(employee_payrolls.cola_amount) as annual_cola_amount,SUM(employee_payrolls.gross_pay) as annual_work_days_amount,SUM(employee_payrolls.witholding_tax) as annual_witholding_tax,SUM(employee_payrolls.hdmf_contribution) as annual_hdmf,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,SUM(employee_payrolls.regular_holiday_day_amount) as regular_holiday_amount,SUM(employee_payrolls.special_holiday_day_amount) as special_holiday_amount,SUM(employee_payrolls.overtime_amount) as overtime_amount,SUM(employee_payrolls.night_diff_amount) as night_diff_amount,employee_payrolls.department,employees.salary_status'))
                ->groupBy('employee_code', 'employees.tin_number', 'employee_payrolls.department', 'employees.custom_thirteen','employees.salary_status')
                ->get();

            // Active
            $totalDues = 0;
            $totalDue = 0;
            $totalRefund = 0;
            foreach ($active_employee as $active) {
                $taxDues = 0;
                if ($active->annual_work_days_amount >= 250000 && $active->annual_work_days_amount <= 399999.99) {
                    $taxDues = ($active->annual_work_days_amount - ($active->annual_sss + $active->annual_phic + $active->annual_hdmf)) - 250000;
                    $taxDues = $taxDues * .2;
                    $totalDues += $taxDues;
                }

                if ($active->annual_work_days_amount >= 400000 && $active->annual_work_days_amount <= 799999.99) {
                    $taxDues = ($active->annual_work_days_amount - ($active->annual_sss + $active->annual_phic + $active->annual_hdmf)) - 400000;
                    $taxDues = ($taxDues * .25) + 30000;
                    $totalDues += $taxDues;
                }
                $totalDue += $taxDues - $active->annual_witholding_tax;
                $totalRefund += $active->annual_witholding_tax - $taxDues;
            }

            //Inactive
            $inactive_totalDues = 0;
            $inactive_totalDue = 0;
            $inactive_totalRefund = 0;
            foreach ($inactive_employee as $inactive) {
                $inactive_taxDues = 0;

                if ($inactive->annual_work_days_amount >= 250000 && $inactive->annual_work_days_amount <= 399999.99) {
                    $inactive_taxDues = ($inactive->annual_work_days_amount - ($inactive->annual_sss + $inactive->annual_phic + $inactive->annual_hdmf)) - 250000;
                    $inactive_taxDues = $inactive_taxDues * .2;
                    $inactive_totalDues += $inactive_taxDues;
                }

                if ($inactive->annual_work_days_amount >= 400000 && $inactive->annual_work_days_amount <= 799999.99) {
                    $inactive_taxDues = ($inactive->annual_work_days_amount - ($inactive->annual_sss + $inactive->annual_phic + $inactive->annual_hdmf)) - 400000;
                    $inactive_taxDues = ($inactive_taxDues * .25) + 30000;
                    $inactive_totalDues += $inactive_taxDues;
                }
                
                $inactive_totalDue += $inactive_taxDues - $active->annual_witholding_tax;
                $inactive_totalRefund += $active->annual_witholding_tax - $inactive_taxDues;
            }

            $data = [
                'employees' => $active_employee,
                'inactive_employees' => $inactive_employee,
                'totalDues' => $totalDues,
                'totalDue' => $totalDue,
                'totalRefund' => $totalRefund,
                'inactive_totalDues' => $inactive_totalDues,
                'inactive_totalDue' => $inactive_totalDue,
                'inactive_totalRefund' => $inactive_totalRefund,
                'year' => Carbon::parse($request['monthRep'])->year
            ];

            $pdf = PDF::loadView('reports.alphalist', $data)->setPaper('Legal', 'Landscape');
            return $pdf->stream('alphalist.pdf');
        }
        // Employee Information Reports
        if ($request['report_type'] == 'EMPLOYEE INFORMATION') {
            $employee_info = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.employee_status', 1)
                ->where('employee_payrolls.year', 2019)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.tin_number', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.sick_leave_amount) as sick_leave_total,SUM(employee_payrolls.thirteen_month) as annual_thirteen,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,SUM(employee_payrolls.sss_contribution) as annual_sss,SUM(employee_payrolls.phic_contribution) as annual_phic,SUM(employee_payrolls.non_tax_other) as annual_non_tax_other,SUM(employee_payrolls.cola_amount) as annual_cola_amount,SUM(employee_payrolls.gross_pay) as annual_work_days_amount,SUM(employee_payrolls.witholding_tax) as annual_witholding_tax,SUM(employee_payrolls.hdmf_contribution) as annual_hdmf,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,employee_payrolls.department'))
                ->groupBy('employee_code', 'employees.tin_number', 'employee_payrolls.department', 'employees.custom_thirteen')
                ->get();

            $inactive_employee = Employee_Payrolls::join('employees', 'employee_payrolls.employee_code', 'employees.id')
                ->orderBy('employees.employee_Lname')
                ->where('employees.employee_status', 2)
                ->where('employee_payrolls.year', 2019)
                ->where('employee_payrolls.department', $request['department'])
                ->select('employee_code', 'employees.tin_number', 'employees.custom_thirteen', DB::raw('SUM(employee_payrolls.work_days_amount) as basic_pay,SUM(employee_payrolls.ext_reg_hrs_ammount) as extra_regular_hrs,SUM(employee_payrolls.sick_leave_amount) as sick_leave_total,SUM(employee_payrolls.thirteen_month) as annual_thirteen,SUM(employee_payrolls.cola_amount) as cola,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,SUM(employee_payrolls.sss_contribution) as annual_sss,SUM(employee_payrolls.phic_contribution) as annual_phic,SUM(employee_payrolls.non_tax_other) as annual_non_tax_other,SUM(employee_payrolls.cola_amount) as annual_cola_amount,SUM(employee_payrolls.gross_pay) as annual_work_days_amount,SUM(employee_payrolls.witholding_tax) as annual_witholding_tax,SUM(employee_payrolls.hdmf_contribution) as annual_hdmf,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,employee_payrolls.department'))
                ->groupBy('employee_code', 'employees.tin_number', 'employee_payrolls.department', 'employees.custom_thirteen')
                ->get();

            $data = [
                'employee_information' => $employee_info,
                'inactive_employees' => $inactive_employee
            ];
            $pdf = PDF::loadView('reports.employeeInformation', $data)->setPaper('Legal', 'Landscape');
            return $pdf->stream('employeeInformation.pdf');
        }
    }
}
