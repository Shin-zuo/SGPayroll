<?php

namespace SGpayroll\Http\Controllers\QuickPayroll;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Excel;
use SGpayroll\Employee;
use SGpayroll\Http\Controllers\Controller;

class QuickPayrollController extends Controller
{
    //
    public function index()
    {
        return view('quickpayroll.index');
    }
    public function importExcel(Request $request)
    {

        if($request->hasFile('import_file')){
            \Config::set('excel.import.startRow', 13);
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                $sheet = $reader->getSheetByName('payrollworks'); // sheet with name data, but you can also use sheet indexes.
//                dd($sheet->getCell('H3')->getValue());
                foreach ($reader->toArray() as $key => $row) {
                    if(strtoupper($sheet->getCell('N7')->getValue()) == 'NO')
                    {
                        $endPayroll = 'false';
                    }
                    else
                    {
                        $endPayroll = 'true';
                    }

                    $employee = Employee::where('employee_id','=',$row['employee_id'])->first();
                    $per_hour_computation = $employee['basic_pay']/8;
                    $basic_amount = $employee['basic_pay']*$row['working_days'];
                    $work_days_amount = ($employee['basic_pay'] + $employee['cola'] + $employee['other_nt_pay'])*$row['working_days'];
                    $over_time_pay = ($per_hour_computation*1.25)*$row['overtime'];
                    $extra_regular_hours = $per_hour_computation*$row['extra_hours'];
                    $night_diff = ($per_hour_computation*1.1)*$row['night_hours'];

//                    RESTDAY
                    if($row['special']==null || $row['special']==0)
                    {
                        $special = '0';

                    }
                    else
                    {
                        $special = ($employee['basic_pay']*1.3)*$row['special']+(($employee['cola']+$employee['other_nt_pay']))*($row['special']);
                    }
                    if($row['overtimesphrs']==null || $row['overtimesphrs']==0)
                    {
                        $rest_special_exc = '0';

                    }
                    else
                    {
                        $rest_special_exc = (($per_hour_computation*1.69)*$row['overtimesphrs']);
                    }
//                    dd($rest_special_exc);
//
//                    $regular_holiday_hour = ($per_hour_computation+($employee['cola']+$employee['other_nt_pay']/8))*$request['regular_holiday_hour'];

//                    REGULAR HOLIDAY
                    $regular_holiday = ($employee['basic_pay']+$employee['cola']+$employee['other_nt_pay'])*$row['regular'];
                    $regular_holiday_hour_exc = ($per_hour_computation*2.6)*$row['overtimereghrs'];
                    $restday_on_regular = ((($employee['basic_pay']+$employee['cola'])*2) + (($employee['basic_pay']*2)*.3))*$row['restdayregday'];
                    $restday_on_regular_exc = ($per_hour_computation*3.38)* $row['restdayreg_othrs'];
                    if($row['restdayspday']==null || $row['restdayspday']==0)
                    {
                        $restday_on_special = 0;
                    }
                    else
                    {
                        $restday_on_special = (($employee['basic_pay']*1.5)+$employee['cola'])*$row['restdayspday'];
                    }
//                    dd($restday_on_special);
                    $restday_on_special_exc = ($per_hour_computation * 1.95) * $row['restdaysp_othrs'];
//                    dd($restday_on_special_exc);
//                    //DEBIT

//                    dd($regular_holiday);
//                    $special_holiday 45= (($employee['basic_pay']*1.3)+$employee['cola']+$employee['other_nt_pay'])*$request['special_holiday'];
//                    //LEAVE PAY
                    $sick_leave = ($employee['basic_pay']+$employee['cola']+$employee['other_nt_pay'])*$row['sick_leave'];
                    $vacation_leave = ($employee['basic_pay']+$employee['cola']+$employee['other_nt_pay'])*$row['vacation_leave'];
////                $service_leave = ($employee['basic_pay']+$employee['cola']+$employee['other_nt_pay'])*$request['service_leave'];
//                    //OTHER PAY
//                    $non_tax_other = $request['nt_pay'];
                    $cola = $employee['cola']*$row['working_days'];
                    $NTothers_pay = $employee['other_nt_pay']*$row['working_days'];
//                    $other_totalAmount = $cola + $NTothers_pay;

                    //GROSSPAY
                    $total_grosspay = $basic_amount +
                        $cola +
                        $NTothers_pay +
                        $over_time_pay +
//                        $other_pay +
                        $extra_regular_hours +
                        $night_diff +
                        $regular_holiday +
//                        $rest_special +
//                        $special_holiday +
                        $rest_special_exc +
//                        $regular_holiday_hour +
                        $regular_holiday_hour_exc +
                        $restday_on_regular +
                        $restday_on_regular_exc +
                        $restday_on_special +
                        $restday_on_special_exc +
                        $sick_leave;
//                    dd($total_grosspay);
                    if ($employee['payroll_type'] == 2)
                    {
                        $basic_amount = round($employee['basic_pay'],2)/2;
                        $total_grosspay = round($employee['basic_pay'],2)/2;
                    }
//                    //Deduction pagibig
//                    $pag_ibig_deduction = 0;
                    if($employee['pag_ibig_contribution']==1)
                    {

                        if ((int)$sheet->getCell('D7')->getValue() == 1 || $sheet->getCell('N7')->getValue() == "YES")
                        {
                            $pag_ibig_deduction = $employee['pagibig_amount']/2;
//                            dd($pag_ibig_deduction);
                        }

                    }

                    if((int)$sheet->getCell('D7')->getValue() == 1 && round($total_grosspay,2) == 0)
                    {
                        $philhealth_deduction = 0;
                        $pag_ibig_deduction = 0;
                    }
                    if((int)$sheet->getCell('D7')->getValue() == 1 && round($total_grosspay,2) < 10000 && $employee['phic_status']==1)
                    {
                        $philhealth_deduction = 150;
                    }
                    else if ((int)$sheet->getCell('D7')->getValue() == 1 && round($total_grosspay,2) > 10000 && round($total_grosspay,2) < 60000 && $employee['phic_status']==1)
                    {
                        $philhealth_deduction = $total_grosspay * 0.015 ;
                    }
                    else if ((int)$sheet->getCell('D7')->getValue() == 1 && round($total_grosspay,2) > 60000 && $employee['phic_status']==1)
                    {
                        $philhealth_deduction = 900.00;
                    }
                    else
                    {
                        $philhealth_deduction = 0;
                    }
                    // dd($philhealth_deduction);
//
                   //SSS
                   if($employee['sss_status'] == 1)
                   {
                       $sss_deduction_total = $total_grosspay*0.04;
                       if($sss_deduction_total>800.00 )
                       {
                           $sss_deduction_total = 800.00;
                       }
                   }
                   else
                   {
                       $sss_deduction_total = 0;
                   }
//                   dd($sss_deduction_total);

                    if($sheet->getCell('D7')->getValue() == "YES")
                    {
                        $total_grosspay_in_month = Employee_Payrolls::where('employee_code','=',$row['employee_id'])->where('monthly_record','=',Carbon::parse($sheet->getCell('H7')->getValue())->month)->where('year','=',Carbon::parse($sheet->getCell('H7')->getValue())->year)->sum('gross_pay');
                        $total_sss_in_month = Employee_Payrolls::where('employee_code','=',$row['employee_id'])->where('monthly_record','=',Carbon::parse($sheet->getCell('D7')->getValue())->month)->where('year','=',Carbon::parse($sheet->getCell('D7')->getValue())->year)->sum('sss_contribution');
                        $total_philhealth_deduction = Employee_Payrolls::where('employee_code','=',$row['employee_id'])->where('monthly_record','=',Carbon::parse($sheet->getCell('D7')->getValue())->month)->where('year','=',Carbon::parse($sheet->getCell('D7')->getValue())->year)->sum('phic_contribution');
                        $monthly_total_grosspay  = round($total_grosspay,2) + round($total_grosspay_in_month);
                        if($employee['phic_status']==1)
                        {
                            if ($total_grosspay == 0)
                            {
                                $philhealth_deduction = 0.00;
                            }
                            if ($monthly_total_grosspay >= 1 && $monthly_total_grosspay <= 10000.00)
                            {
                                $philhealth_deduction = round(150,2) - $total_philhealth_deduction;
                            }
                            if($monthly_total_grosspay >= 10000.01 && $monthly_total_grosspay <= 59999.99)
                            {
                                $philhealth_deduction = (round($monthly_total_grosspay,2)*0.03/2) - $total_philhealth_deduction;
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

                        }
                        else
                        {
                            $sss_deduction_total = 0;
                        }
                    }

                    //WITHOLDING TAX for Payroll 1
                    if($employee['tax_status'])
                    {
                        if(round($total_grosspay,2) <= 10417.00)
                        {
                            $witholding_tax_deduction = 0;
                        }
                        if(round($total_grosspay,2) >= 10417.01 && round($total_grosspay,2) <= 16667.00)
                        {
                            $witholding = ($total_grosspay - 10417) * 0.2;
                            $witholding_tax_deduction = $witholding;
                        }
                        if(round($total_grosspay,2) >= 16667.01 && round($total_grosspay,2) <= 33333.00)
                        {
                            $witholding = ($total_grosspay-16667.00) * 0.25;
                            $witholding_tax_deduction = $witholding + 1250.00;
                        }
                        if(round($total_grosspay,2) >= 33333.01 && round($total_grosspay,2) <= 83333.00)
                        {
                            $witholding = ($total_grosspay-33333.00) * 0.3;
                            $witholding_tax_deduction = $witholding + 5416.67;
                        }
                        if(round($total_grosspay,2) >= 83333.01 && round($total_grosspay,2) <= 333333.00)
                        {
                            $witholding = ($total_grosspay-83333.00) * 0.32;
                            $witholding_tax_deduction = $witholding + 20416.67;
                        }
                        if(round($total_grosspay,2) >= 333333.01)
                        {
                            $witholding = ($total_grosspay-333333.00) * 0.35;
                            $witholding_tax_deduction = $witholding + 100416.67;
                        }
                    }
                    else
                    {
                        $witholding_tax_deduction = 0;
                    }

                    $total_deduction = $sss_deduction_total + $philhealth_deduction + $pag_ibig_deduction;
                    $ot_pay_total = $over_time_pay +
                        $night_diff +
                        $extra_regular_hours +
//                        $rest_special +
                        $rest_special_exc +
//                        $regular_holiday_hour +
                        $regular_holiday_hour_exc +
                        $restday_on_regular +
                        $restday_on_regular_exc +
                        $restday_on_special +
                        $restday_on_special_exc;
                    $leave_pay_total = $vacation_leave + $sick_leave;
                    $net_pay = $total_grosspay-$total_deduction-$witholding_tax_deduction;

//DATA TO INSERT

                    $data['employee_code'] = $row['employee_id'];
                    $data['department'] = strtoupper($sheet->getCell('F1')->getValue());
                    $data['work_days'] = $row['working_days'];
                    $data['work_days_amount'] = $work_days_amount;
                    $data['overtime'] = $row['overtime'];
                    $data['overtime_amount'] = $over_time_pay;
                    $data['ext_reg_hrs'] = $row['extra_hours'];
                    $data['ext_reg_hrs_ammount'] =  $extra_regular_hours;
                    $data['night_diff'] = $row['night_hours'];
                    $data['night_diff_amount'] = $night_diff;
                    $data['rest_special'] = $row['special'];
                    $data['rest_special_amount'] = $special;
                    $data['exc_rest_special'] = $row['overtimesphrs'];
                    $data['exc_rest_special_amount'] = $rest_special_exc;
                    $data['regular_holiday'] = $row['regular'];
                    $data['regular_holiday_amount'] =  $regular_holiday;
                    $data['exc_regular_holiday'] = $row['overtimereghrs'];
                    $data['exc_regular_holiday_amount'] = $regular_holiday_hour_exc;
                    $data['rest_on_regular'] = $row['restdayregday'];
                    $data['rest_on_regular_amount'] = $restday_on_regular;
                    $data['exc_rest_on_regular'] = $row['restdayreg_othrs'];
                    $data['exc_rest_on_regular_amount'] =  $restday_on_regular_exc;
                    $data['rest_on_special'] = $row['restdayspday'];
                    $data['rest_on_special_amount'] = $restday_on_special;
                    $data['exc_rest_on_special'] = $row['restdaysp_othrs'];
                    $data['exc_rest_on_special_amount'] = $restday_on_special_exc;
                    $data['sick_leave'] = $row['sick_leave'];
                    $data['sick_leave_amount'] = $sick_leave;
                    $data['vacation_leave'] = $row['vacation_leave'];
                    $data['vacation_leave_amount'] = $vacation_leave;
                    $data['cola_amount'] = $cola;
                    $data['non_tax_other'] = $NTothers_pay;
                    $data['gross_pay'] = $total_grosspay;
                    $data['witholding_tax'] = $witholding_tax_deduction;
                    $data['sss_contribution'] = $sss_deduction_total;
                    $data['phic_contribution'] = $philhealth_deduction;
                    $data['hdmf_contribution'] =  $pag_ibig_deduction;
                    $data['net_pay'] = $net_pay;
                    $data['payroll_number'] = (int)$sheet->getCell('D7')->getValue();
                    $data['date_from'] = $sheet->getCell('H7')->getValue();
                    $data['date_to'] = $sheet->getCell('J7')->getValue();
                    $data['endMonth'] = $endPayroll;
                    $data['monthly_record'] = Carbon::parse($sheet->getCell('H7')->getValue())->month;
                    $data['year'] = Carbon::parse($sheet->getCell('H7')->getValue())->year;
                    if(!empty($data)) {
                        DB::table('employee_payrolls')->insert($data);
                    }

                }


            });
        }

        Session::put('success', 'You file successfully import in database!!!');

        return back();
    }
}
