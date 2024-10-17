<?php

namespace SGpayroll\Http\Controllers\Payroll;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use SGpayroll\Department;
use SGpayroll\Employee;
use SGpayroll\Employee_Loan;
use SGpayroll\Employee_Payrolls;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Phil_Table;
use SGpayroll\Sss_Table;
use SGpayroll\Sub_Department;
use SGpayroll\User;

class PayrollController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {
//        dd($id);
        $employee = Employee::where('employee_status',"1")->where('department',$id)->orderBy('employee_Lname','ASC')->get();
        $data  = [
            "employee" => $employee,
            "department" => $id,
        ];
        return view('payroll.index')->with($data);
    }
    public function departmentData(Request $request)
    {
        $department = Department::all();
        return $department;
    }
    public function payrollNo(Request $request)
    {

       $payrollNo = Employee_Payrolls::where('department' ,$request['deptCode'])->orderBy('created_at','desc')->first();
       return ["payrollNo" => $payrollNo->payroll_number,
       "endMonth" => $payrollNo->endMonth,
       "payroll_type" => $payrollNo->employee->payroll_type];
    }
    public function dataDeptEmployee(Request $request)
    {
       $employee = Employee::where('department','=',$request['department'])->orderBy('employee_Fname','ASC')->get();
        return $employee;
    }
    public function BasicComputation(Request $request)
    {
        // Get the employee records
        $employee = Employee::find($request['employee_id']);
        $other_pay = $request['other_pay'];
        $thirteen_month = $request['thirteen_month'];
        $per_hour_computation = $employee['basic_pay']/8;
        $basic_amount = $employee['basic_pay']*$request['work_days'];
        $work_days_amount = ($employee['basic_pay'] + $employee['cola'] + $employee['other_nt_pay'])*$request['work_days'];
        $over_time_pay = ($per_hour_computation*1.25)*$request['overtime_hours'];
        $extra_regular_hours = $per_hour_computation*$request['extra_regular_hour'];
        $night_diff = ($per_hour_computation*0.1)*$request['night_diff'];
        $absent = ($employee['basic_pay'] + $employee['cola'] + $employee['other_nt_pay'])*$request['absent'];
        //RESTDAY
        if($request['rest_special']==null || $request['rest_special']==0) {
            $rest_special = '0';
        } else {
            $rest_special = ($per_hour_computation*1.3)*$request['rest_special']+(($employee['cola']+$employee['other_nt_pay']/8))*($request['rest_special']/8);
        }
        if($request['rest_special_exc']==null || $request['rest_special_exc']==0) {
            $rest_special_exc = '0';
        } else {
            $rest_special_exc = (($per_hour_computation*1.69)*$request['rest_special_exc']);
        }
        $regular_holiday_hour = ($per_hour_computation+($employee['other_nt_pay']/8))*$request['regular_holiday_hour'];
        $regular_holiday_hour_exc = ($per_hour_computation*2.6)*$request['regular_holiday_hour_exc'];
        $restday_on_regular = (($per_hour_computation*2+($employee['cola']/8)*2) + (($per_hour_computation*2)*.3)) * $request['restday_on_regular'];
        $restday_on_regular_exc = ($per_hour_computation*3.38)* $request['restday_on_regular_exc'];
        if($request['restday_on_special']==null || $request['restday_on_special']==0) {
            $restday_on_special = 0;
        } else {
            $restday_on_special = (($per_hour_computation*1.5)* $request['restday_on_special']) + $employee['cola'];
        }
        $restday_on_special_exc = ($per_hour_computation * 1.95) * $request['restday_on_special_exc'];
        //DEBIT
        // For above minimum
        $regular_holiday = ($employee['basic_pay']+$employee['other_nt_pay'])*$request['regular_holiday'];
        $special_holiday = (($employee['basic_pay']*1.3)+$employee['other_nt_pay'])*$request['special_holiday'];
        //For minimum wager
        $regular_holiday_minimum = ($employee['basic_pay']+$employee['other_nt_pay'])*$request['regular_holiday_minimum'];
        $special_holiday_minimum = (($employee['basic_pay']*1.3)+$employee['other_nt_pay'])*$request['special_holiday_minimum'];
        //LEAVE PAY
        $sick_leave = ($employee['basic_pay']+$employee['other_nt_pay'])*$request['sick_leave'];
        $vacation_leave = ($employee['basic_pay']+$employee['other_nt_pay'])*$request['vacation_leave'];
        //OTHER PAY
        $non_tax_other = $request['nt_pay'];
        $cola = $employee['cola']*$request['work_days'];
        $NTothers_pay = $employee['other_nt_pay']*$request['work_days'];
        $other_totalAmount = $cola + $NTothers_pay;
        //LOANS
        $status_sss = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('active');
        $status_sss_calamity = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('active');
        $status_hdmf = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('active');
        $status_company = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('active');
        $status_other =  $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('active');
        $status_insurance = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('active');
        $status_rent = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','7')->pluck('active');
        if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','1')->count() > 0 && $status_sss[0] == 'true') {
            $deduction_date_sss= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('deduction_date');
            $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('remaining_term');
            if($remaining_term[0] > 0 && Carbon::parse($deduction_date_sss[0]) <= Carbon::now() ) {
                $sss_salary_loan = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('deduction');
                $sss_salary_loan = $sss_salary_loan[0];
            } else {
                $sss_salary_loan = 0 ;
            }
        } else {
            $sss_salary_loan = 0 ;
        }
        if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','2')->count() > 0 && $status_sss_calamity[0] == 'true')
        {
            $deduction_date_sss_calamity= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('deduction_date');
            $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('remaining_term');
            if($remaining_term[0] > 0 && Carbon::parse($deduction_date_sss_calamity[0]) <= Carbon::now() )
            {
                $sss_calamity_loan = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('deduction');
                $sss_calamity_loan = $sss_calamity_loan[0];
            }
            else
            {
                $sss_calamity_loan = 0 ;
            }
        }
        else
        {
            $sss_calamity_loan  = 0 ;
        }
                if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','3')->count() > 0 && $status_hdmf[0] == 'true' )
                {
                    $deduction_date_hdmf= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('deduction_date');
                    $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('remaining_term');
                    if($remaining_term[0] > 0 && Carbon::parse($deduction_date_hdmf[0]) <= Carbon::now() )
                    {
                        $hdmf_loan = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('deduction');
                        $hdmf_loan = $hdmf_loan[0];
                    }
                    else
                    {
                        $hdmf_loan = 0;
                    }

                }
                else
                {
                    $hdmf_loan = 0;
                }
                if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','4')->count() > 0 && $status_company[0]== 'true')
                {

                    $deduction_date_company= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('deduction_date');
                    $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('remaining_term');
                    if($remaining_term[0] > 0 && Carbon::parse($deduction_date_company[0]) <= Carbon::now())
                    {
                        $company_loan = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('deduction');
                        $company_loan = $company_loan[0];
                    }
                    else
                    {
                        $company_loan = 0;
                    }
                }
                else
                {
                    $company_loan = 0;
                }
        if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','5')->count() > 0 && $status_other[0]== 'true')
        {
            $deduction_date_other= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('deduction_date');
            $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('remaining_term');
            if($remaining_term[0] > 0 && Carbon::parse($deduction_date_other[0]) < Carbon::now())
            {
                $other_loan = $employee->find
                ($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('deduction');
                $other_loan = $other_loan[0];
            }
            else
            {
                $other_loan = 0;
            }
        }
        else
        {
            $other_loan = 0;
        }
        if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','6')->count() > 0 && $status_insurance[0]== 'true')
        {
            $deduction_date_insurance= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('deduction_date');
            $remaining_term = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('remaining_term');
            if($remaining_term[0] > 0 && Carbon::parse($deduction_date_insurance[0]) < Carbon::now())
            {
                $insurance = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('deduction');
                $insurance = $insurance[0];
            }
            else
            {
                $insurance = 0;
            }
        }
        else
        {
            $insurance = 0;
        }
        if($employee->find($request['employee_id'])->employee_loans->where('loan_type','=','7')->count() > 0 && $status_rent[0]== 'true')
        {
            $deduction_date_rent= $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','7')->pluck('deduction_date');
            if(Carbon::parse($deduction_date_rent[0]) < Carbon::now())
            {
                $rent = $employee->find($request['employee_id'])->employee_loans->where('loan_type','=','7')->pluck('deduction');
                $rent = $rent[0];
            }
            else
            {
                $rent = 0;
            }
        }
        else
        {
            $rent = 0;
        }

                $total_loan_deduction = $sss_salary_loan + $sss_calamity_loan + $hdmf_loan + $company_loan + $insurance + $other_loan + $rent;
                //GROSSPAY
                    $total_grosspay = $basic_amount +
                        $cola +
                        $NTothers_pay +
                        $over_time_pay +
                        $other_pay +
                        $thirteen_month +
                        $extra_regular_hours +
                        $night_diff +
                        $regular_holiday +
                        $rest_special +
                        $regular_holiday_minimum +
                        $special_holiday_minimum +
                        $special_holiday +
                        $rest_special_exc +
                        $regular_holiday_hour +
                        $regular_holiday_hour_exc +
                        $restday_on_regular +
                        $restday_on_regular_exc +
                        $restday_on_special +
                        $restday_on_special_exc +
                        $sick_leave +
                        $vacation_leave -
                        $absent;
                if ($employee['payroll_type'] == 2)
                {
                    $basic_amount = round($employee['basic_pay'],2)/2;
                    $total_grosspay = round($employee['basic_pay'],2)/2;
                }

                //Deduction pagibig
                $pag_ibig_deduction = 0;
                if($employee['pag_ibig_contribution']==1)
                {

                    if ($request['payroll_no']==1 || $request['endMonth'] == "true")
                    {
                        $pag_ibig_deduction = $employee['pagibig_amount']/2;
//                        dd($pag_ibig_deduction);
                    }

                }
                if($request['payroll_no'] == 1 && round($total_grosspay,2) == 0)
                {
                    $philhealth_deduction = 0;
                    $pag_ibig_deduction = 0;
                }
                if($request['payroll_no'] == 1 && round($total_grosspay,2) < 10000 && $employee['phic_status']==1)
                {
                    $philhealth_deduction = 250;
                }
                else if ($request['payroll_no'] == 1 && round($total_grosspay,2) > 10000 && round($total_grosspay,2) < 60000 && $employee['phic_status']==1)
                {
                    $philhealth_deduction = $total_grosspay * 0.025 ;
                }
                else if ($request['payroll_no'] == 1 && round($total_grosspay,2) > 60000 && $employee['phic_status']==1)
                {
                    $philhealth_deduction = 900.00;
                }
                else
                {
                    $philhealth_deduction = 0;
                }

                //SSS
                if($employee['sss_status'] == 1)
                {
                    $sss_deduction_total = $total_grosspay*0.045;
                    $sss_provident_fund = 0;
                    if($sss_deduction_total>900.00 )
                    {
                        $sss_deduction_total = 900.00;
                    }
                }
                else
                {
                    $sss_provident_fund = 0;
                    $sss_deduction_total = 0;
                }
                if($request['endMonth'] == "true")
                {
                    $total_grosspay_in_month = Employee_Payrolls::where('employee_code','=',$request['employee_id'])->where('monthly_record','=',Carbon::parse($request['date_from'])->month)->where('year','=',Carbon::parse($request['date_from'])->year)->where('payroll_number' ,'!=',$request['payroll_no'])->sum('gross_pay');
                    $total_sss_in_month = Employee_Payrolls::where('employee_code','=',$request['employee_id'])->where('monthly_record','=',Carbon::parse($request['date_from'])->month)->where('year','=',Carbon::parse($request['date_from'])->year)->where('payroll_number' ,'!=',$request['payroll_no'])->sum('sss_contribution');
                    $total_philhealth_deduction = Employee_Payrolls::where('employee_code','=',$request['employee_id'])->where('monthly_record','=',Carbon::parse($request['date_from'])->month)->where('year','=',Carbon::parse($request['date_from'])->year)->where('payroll_number' ,'!=',$request['payroll_no'])->sum('phic_contribution');
                    $monthly_total_grosspay  = round($total_grosspay,2) + round($total_grosspay_in_month);
                    if($employee['phic_status']==1)
                    {
                        if ($total_grosspay == 0)
                        {
                            $philhealth_deduction = 0.00;
                        }
                        if ($monthly_total_grosspay >= 1 && $monthly_total_grosspay <= 10000.00)
                        {
                            $philhealth_deduction = round(0,2);
                        }
                        if($monthly_total_grosspay >= 10000.01 && $monthly_total_grosspay <= 59999.99)
                        {
                            $philhealth_deduction = (round($monthly_total_grosspay,2)*0.05/2) - $total_philhealth_deduction;
                        }
                        if($monthly_total_grosspay >= 60000.00 && $monthly_total_grosspay <= 9999999999999.99)
                        {
                            $philhealth_deduction = round(900.0,2)- $total_philhealth_deduction;
                        }
                    }
                    else{
                        $philhealth_deduction = 0;
                    }

                    //SSS Deduction for Payroll 2
                    if($employee['sss_status'] == 1)
                    {
                        $sss_deduction = Sss_Table::whereRaw('? between range_from and range_to', [round($monthly_total_grosspay, 2)])->get();
                        $sss_deduction_total = $sss_deduction[0]['sss_ee'] - $total_sss_in_month;
                        $sss_provident_fund = $sss_deduction[0]['provident_fund']*.045;
                    }
                    else
                    {
                        $sss_provident_fund = 0;
                        $sss_deduction_total = 0;
                    }
                }

        
                $total_deduction = $sss_deduction_total + $philhealth_deduction + $pag_ibig_deduction;
                $ot_pay_total = $over_time_pay +
                    $night_diff +
                    $extra_regular_hours +
                    $rest_special +
                    $rest_special_exc +
                    $regular_holiday_hour +
                    $regular_holiday_hour_exc +
                    $restday_on_regular +
                    $restday_on_regular_exc +
                    $restday_on_special +
                    $restday_on_special_exc;
                $leave_pay_total = $vacation_leave + $sick_leave;
                $gross_deducted_witholding = $total_grosspay - $total_deduction;
                
                //WITHOLDING TAX for Payroll 1
        if($employee['tax_status'])
        {
            if ($gross_deducted_witholding <= 10417.00)
            {
                $witholding_tax_deduction = 0;
            }
            if ($gross_deducted_witholding >= 10417.01 && $gross_deducted_witholding <= 16667.00)
            {
                $witholding = ($gross_deducted_witholding - 10417) * 0.15;
                $witholding_tax_deduction = $witholding;
            }
            if ($gross_deducted_witholding >= 16667.01 && $gross_deducted_witholding <= 33333.00)
            {
                $witholding = ($gross_deducted_witholding-16667.00) * 0.20;
                $witholding_tax_deduction = $witholding + 935.50;
            }
            if ($gross_deducted_witholding >= 33333.01 && $gross_deducted_witholding <= 83333.00)
            {
                $witholding = ($gross_deducted_witholding-33333.00) * 0.25;
                $witholding_tax_deduction = $witholding + 4270.70;
            }
            if($gross_deducted_witholding >= 83333.01 && $gross_deducted_witholding <= 333333.00)
            {
                $witholding = ($gross_deducted_witholding-83333.00) * 0.30;
                $witholding_tax_deduction = $witholding + 16770.70;
            }
            if ($gross_deducted_witholding >= 333333.01)
            {
                $witholding = ($total_grosspay-333333.00) * 0.35;
                $witholding_tax_deduction = $witholding + 91770.70;
            }
        }
        else
        {
            $witholding_tax_deduction = 0;
        }
                $net_pay = (($total_grosspay-$total_deduction)-($total_loan_deduction+$sss_provident_fund))-$witholding_tax_deduction;

            return [
                //BASIC PAY
                "basic_pay" => round($basic_amount,2),
                "work_days_amount" => round($work_days_amount,2),
                "over_time_amount" => round($over_time_pay,2),
                "extra_regular_hours_amount" => round($extra_regular_hours,2),
                "night_diff_amount" => round($night_diff,2),
                //HOLIDAY
                "rest_special_amount" => round($rest_special,2),
                "rest_special_exc_amount" => round($rest_special_exc,2),
                "regular_holiday_hour_amount" => round($regular_holiday_hour,2),
                "regular_holiday_hour_exc_amount" => round($regular_holiday_hour_exc,2),
                "restday_on_regular_amount" => round($restday_on_regular,2),
                "restday_on_regular_exc_amount" => round($restday_on_regular_exc,2),
                "restday_on_special" => round($restday_on_special,2),
                "restday_on_special_exc" => round($restday_on_special_exc,2),
                "total_grosspay" => round($total_grosspay,2),
                "extra_regular_hour" => round($extra_regular_hours,2),
                "night_diff" =>round($night_diff,2),
                "rest_special" =>round($rest_special,2),
                "regular_holiday_hour" => round($regular_holiday_hour,2),
                "regular_holiday_hour_exc" => round($regular_holiday_hour_exc,2),
                //LEAVE
                "vacation_leave" => round($vacation_leave,2),
                "sick_leave" => round($sick_leave,2),
                //OTHER PAY
                "cola" => round($cola,2),
                "Ntother_pay" => round($NTothers_pay ,2) + round($request['other_pay'] ,2),
                "other_totalAmount" => $other_totalAmount,
                //DEBIT
                "regular_holiday" => $regular_holiday,
                "special_holiday" => $special_holiday,
                "regular_holiday_minimum" => $regular_holiday_minimum,
                "special_holiday_minimum" => $special_holiday_minimum,
                //DEDUCTION
                "sss_deduction" => round($sss_deduction_total,2),
                "provident_fund" => round($sss_provident_fund,2),
                "phil_deduction" => round($philhealth_deduction,2),
                "pagibig_deduction" => round($pag_ibig_deduction,2),
                "insurance" => round($insurance,2),
                "witholding_tax" => round($witholding_tax_deduction,2),
                //LOAN
                "sss_loan_deduction" => round($sss_salary_loan,2),
                "sss_calamity_loan" => round($sss_calamity_loan,2),
                "pagibig_loan_deduction" => round($hdmf_loan,2),
                "company_loan_deduction" => round($company_loan,2),
                "other_loan" => round($other_loan,2),
                "rent" => round($rent,2),
                //NET PAY
                "net_pay" => round($net_pay,2),
                //TOTAL
                "ot_pay_total" => round($ot_pay_total,2),
                //LEAVE
                "leave_pay_total" => round($leave_pay_total,2)
            ];
    }
    public function insertFinishData(Request $request)
    {
        if($request['payroll_no'] > 2)
        {
            $report_monthly = Carbon::parse($request['date_from'])->month;
            $year = Carbon::parse($request['date_from'])->year;
        }
        else
        {
            $report_monthly = Carbon::parse($request['date_to'])->month;
            $year = Carbon::parse($request['date_to'])->year;
        }
        Employee_Payrolls::create([
            'employee_code' => $request['employee_id'],
            'department' => $request['department'],
            'work_days' => $request['work_days'],
            'work_days_amount' => round($request['basic_pay'],2),
            'overtime' => $request['overtime_hours'],
            'overtime_amount' => round($request['over_time_amount'],2),
            'ext_reg_hrs' => $request['extra_regular_hour'],
            'ext_reg_hrs_ammount' => round($request['extra_regular_hours_amount'],2),
            'night_diff' => $request['night_diff'],
            'night_diff_amount' => round($request['night_diff_amount'],2),
            'rest_special' => $request['rest_special'],
            'rest_special_amount' => round($request['rest_special_amount'],2),
            'exc_rest_special' => $request['rest_special_exc'],
            'exc_rest_special_amount' => round($request['rest_special_exc_amount'],2),
            //DEBIT HOLIDAY
            'regular_holiday' => $request['regular_holiday_hour'],
            'regular_holiday_amount' => round($request['regular_holiday_hour_amount'],2),
            'exc_regular_holiday' => $request['regular_holiday_hour_exc'],
            'exc_regular_holiday_amount' => round($request['regular_holiday_hour_exc_amount'],2),
            'rest_on_regular' =>"0",
            'rest_on_regular_amount' => "0",
            'exc_rest_on_regular' => "0",
            'exc_rest_on_regular_amount' => "0",
            'rest_on_special' => $request['restday_on_special'],
            'rest_on_special_amount' => "0",
            'exc_rest_on_special' => "0",
            'exc_rest_on_special_amount' => "0",
            'absent' => "0",
            'absent_amount'=> "0",
            'late'=> "0",
            'late_amount'=> "0",
            'regular_holiday_day' => $request['regular_holiday'],
            'regular_holiday_day_amount'=> round($request['regular_holiday_amount'],2),
            'special_holiday_day' => $request['special_holiday'],
            'special_holiday_day_amount' => round($request['special_holiday_amount'],2),
            'regular_holiday_day_minimum' => $request['regular_holiday_minimum'],
            'regular_holiday_day_minimum_amount'=> round($request['regular_holiday_minimum_amount'],2),
            'special_holiday_day_minimum' => $request['special_holiday_minimum'],
            'special_holiday_day_minimum_amount' => round($request['special_holiday_minimum_amount'],2),
            'sick_leave'=> $request['sick_leave'],
            'sick_leave_amount'=> round($request['sick_leave_amount'],2),
            'vacation_leave'=> $request['vacation_leave'],
            'vacation_leave_amount'=> round($request['vacation_leave_amount'],2),
            'total_basic_pay'=> "0",
            'representation'=> "0",
            'transportation'=> "0",
            'cola_amount'=> round($request['cola'],2),
            'FHA'=> "0",
            'regular_other'=> "0",
            'commission'=> "0",
            'pro_sharing'=> "0",
            'hazard_pay'=> "0",
            'fees'=> "0",
            'supplementary_other'=> "0",
            'thirteen_month'=> round($request['thirteen_month'],2),
            'non_tax_other'=> round($request['nt_pay'],2),
            'total_other_pay'=> "0",
            'payroll_number'=> $request['payroll_no'],
            'gross_pay'=> round($request['total_gross'],2),
            'date_from'=> $request['date_from'],
            'date_to'=> $request['date_to'],
            'monthly_record' => $report_monthly,
            'year' => $year,
            'endMonth' => $request['endMonth'],
            'witholding_tax'=> round($request['witholding'],2),
            'sss_contribution' => round($request['sss'],2),
            'provident_fund' => round($request['provident_fund'],2),
            'phic_contribution' => round($request['phil_health'],2),
            'hdmf_contribution' => round($request['pag_ibig'],2),
            'insurance' => round($request['insurance'],2),
            'union'=> "0",
            'sss_loan'=> round($request['sss_loan'],2),
            'sss_calamity_loan' => round($request['sss_calamity_loan'],2),
            'hdmf_loan'=> round($request['pagibig_loan'],2),
            'company_loan'=> round($request['company_loan'],2),
            'other_loan'=>  round($request['other_loan'],2),
            'rent' => round($request['rent'],2),
            'total_deduction'=> "0",
            'gross_deducted_witholding' => "0",
            'net_pay' => $request['net_pay'],
        ]);

        $remaining_term_sss =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('remaining_term');
        $remaining_balance_sss =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','1')->pluck('balance');
        $remaining_term_sss_calamity =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('remaining_term');
        $remaining_balance_sss_calamity = Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','2')->pluck('balance');
        $remaining_term_hdmf =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('remaining_term');
        $remaining_balance_hdmf = Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','3')->pluck('balance');
        $remaining_term_advancement =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('remaining_term');
        $remaining_balance_advancement = Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','4')->pluck('balance');
        $remaining_term_coop =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('remaining_term');
        $remaining_balance_coop = Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','5')->pluck('balance');
        $remaining_term_insurance =  Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('remaining_term');
        $remaining_balance_insurance = Employee::find($request['employee_id'])->employee_loans->where('loan_type','=','6')->pluck('balance');
        $remaining_leave =  Employee::find($request['employee_id']);
        Employee::find($request['employee_id'])->update([
            "leave" => $remaining_leave['leave'] - $request['sick_leave']
        ]);
        Employee::find($request['employee_id'])->update([
            "sick_leave" => $remaining_leave['sick_leave'] - $request['vacation_leave']
        ]);
        if ($request['sss_loan'] != 0 && $remaining_term_sss[0] > 0)
        {
            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','1')->update([
                "remaining_term" => $remaining_term_sss[0]-1,
                "balance" => $remaining_balance_sss[0] - $request['sss_loan'],
            ]);
        }
        if ($request['sss_calamity_loan'] != 0 && $remaining_term_sss_calamity[0] > 0)
        {
            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','2')->update([
                "remaining_term" => $remaining_term_sss_calamity[0]-1,
                "balance" => $remaining_balance_sss_calamity[0]  - $request['sss_calamity_loan']
            ]);
        }
        if ($request['pagibig_loan'] != 0 && $remaining_term_hdmf[0] > 0)
        {

            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','3')->update([
                "remaining_term" => $remaining_term_hdmf[0]-1,
                "balance"  => $remaining_balance_hdmf[0]  - $request['pagibig_loan']
            ]);

        }
        //ADVANCEMENT
        if ($request['company_loan'] != 0 && $remaining_term_advancement[0] > 0)
        {
            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','4')->update([
                "remaining_term" => $remaining_term_advancement[0]-1,
                "balance" => $remaining_balance_advancement[0] - $request['company_loan']
            ]);
        }
        //COOP LOAN
        if ($request['other_loan'] != 0 && $remaining_term_coop[0] > 0)
        {

            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','5')->update([
                "remaining_term" => $remaining_term_coop[0]-1,
                "balance" => $remaining_balance_coop[0] - $request['other_loan']
            ]);
        }
        //INSURANCE
        if ($request['insurance'] != 0 && $remaining_term_insurance[0] > 0)
        {

            Employee_Loan::where('employee_id','=',$request['employee_id'])->where('loan_type','=','6')->update([
                "remaining_term" => $remaining_term_insurance[0]-1,
                "balance" => $remaining_balance_insurance[0] - $request['insurance']
            ]);
        }

        return [
            'employee' => Employee::find($request['employee_id'])->getFullNameAttribute()
        ];

    }
    public function updateData(Request $request)
    {
//        dd($request);
       Employee_Payrolls::find($request['payroll_id'])->update([
           'work_days' => $request['work_days'],
           'work_days_amount' => $request['work_days_amount'],
           'overtime' => $request['overtime_hours'],
           'overtime_amount' => $request['overtime_hours_amount'],
           'ext_reg_hrs' => $request['extra_regular_hour'],
           'ext_reg_hrs_ammount' => $request['extra_regular_hour_amount'],
           'night_diff' => $request['night_diff'],
           'night_diff_amount' => $request['night_diff_amount'],
           'rest_special' => $request['rest_special'],
           'rest_special_amount' => $request['rest_special_amount'],
           'exc_rest_special' => $request['rest_special_exc'],
           'exc_rest_special_amount' => $request['rest_special_exc_amount'],
           'regular_holiday' => $request['regular_holiday_hour'],
           'regular_holiday_amount' => $request['regular_holiday_hour_amount'],
           'exc_regular_holiday' => $request['regular_holiday_hour_exc'],
           'exc_regular_holiday_amount' => $request['regular_holiday_hour_exc_amount'],
           'rest_on_regular' => $request['restday_on_regular'],
           'rest_on_regular_amount' => $request['restday_on _regular_amount'],
           'exc_rest_on_regular' => $request['restday_on_regular_exc'],
           'exc_rest_on_regular_amount' => $request['restday_on_regular_exc_amount'],
           'rest_on_special' =>  $request['restday_on_special'],
           'rest_on_special_amount'  => $request['restday_on_special_amount'],
           'exc_rest_on_special' => $request['restday_on_special_exc'],
           'exc_rest_on_special_amount' => $request['restday_on_special_exc_amount'],
           'regular_holiday_day' => $request['regular_holiday_day'],
           'regular_holiday_day_amount' => $request['regular_holiday_day_amount'],
           'special_holiday_day' => $request['special_holiday'],
           'special_holiday_day_amount' => $request['special_holiday_amount'],
           'sick_leave' => $request['incentive_leave'],
           'sick_leave_amount' => $request['incentive_leave_amount'],
           'cola_amount' => $request['cola_amount'],
           'non_tax_other' => $request['non_tax_other'],
           'gross_pay' => $request['gross_pay'],
           'witholding_tax' => $request['wt_amount'],
           'sss_contribution' => $request['sss_contribution'],
           'phic_contribution' => $request['phic_contribution'],
           'hdmf_contribution' => $request['hdmf_contribution'],
           'insurance' => $request['insurance'],
           'sss_loan' => $request['sss_loan'],
           'hdmf_loan' => $request['hdmf_loan'],
           'other_loan' => $request['other_loan'],
           'rent' => $request['rent'],
           'net_pay' => $request['net_pay']
       ]);
       return 0;
    }
    public function payrollReport()
    {
        $data["info"] = "I is usefull!";
        $pdf = PDF::loadView('payroll.reports.payroll-report', $data)->setPaper('legal','landscape');
        return $pdf->stream('payroll-report.pdf');
    }

}
