<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee_Payrolls extends Model
{
    //
    protected $table = 'employee_payrolls';

    protected $fillable = [
        'employee_code',
        'department',
        'work_days',
        'work_days_amount',
        'overtime',
        'overtime_amount',
        'ext_reg_hrs',
        'ext_reg_hrs_ammount',
        'night_diff',
        'night_diff_amount',
        'night_diff_restday',
        'night_diff_restday_amount',
        'rest_special',
        'rest_special_amount',
        'exc_rest_special',
        'exc_rest_special_amount',
        'regular_holiday',
        'regular_holiday_amount',
        'exc_regular_holiday',
        'exc_regular_holiday_amount',
        'rest_on_regular',
        'rest_on_regular_amount',
        'exc_rest_on_regular',
        'exc_rest_on_regular_amount',
        'rest_on_special',
        'rest_on_special_amount',
        'exc_rest_on_special',
        'exc_rest_on_special_amount',
        'absent',
        'absent_amount',
        'late',
        'late_amount',
        'regular_holiday_day',
        'regular_holiday_day_amount',
        'special_holiday_day',
        'special_holiday_day_amount',
        'regular_holiday_day_minimum',
        'regular_holiday_day_minimum_amount',
        'special_holiday_day_minimum',
        'special_holiday_day_minimum_amount',
        'sick_leave',
        'sick_leave_amount',
        'vacation_leave',
        'vacation_leave_amount',
        'service_leave',
        'service_leave_amount',
        'total_basic_pay',
        'representation',
        'transportation',
        'cola',
        'cola_amount',
        'FHA',
        'regular_other',
        'commission',
        'pro_sharing',
        'hazard_pay',
        'fees',
        'supplementary_other',
        'thirteen_month',
        'non_tax_other',
        'total_other_pay',
        'payroll_number',
        'gross_pay',
        'date_from',
        'date_to',
        'monthly_record',
        'year',
        'endMonth',
        'witholding_tax',
        'sss_contribution',
        'provident_fund',
        'phic_contribution',
        'hdmf_contribution',
        'union',
        'insurance',
        'sss_loan',
        'sss_calamity_loan',
        'hdmf_calamity_loan',
        'hdmf_loan',
        'company_loan',
        'other_loan',
        'rent',
        'total_deduction',
        'net_pay',
    ];
    public function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_code');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class,'department','department_name');
    }
    public function sss()
    {
        $sss_report =  Sss_Table::whereRaw('? between range_from and range_to', [round($this->total_gross,2)])->get();
        return $sss_report[0];
    }
//    public function taxDue()
//    {
//        $sample = Employee_Payrolls::join('employees','employee_payrolls.employee_code','employees.id')
//            ->orderBy('employees.employee_Lname')
//            ->select('employee_code','employees.tin_number','employees.custom_thirteen', DB::raw('SUM(employee_payrolls.sss_contribution) as annual_sss,SUM(employee_payrolls.phic_contribution) as annual_phic,SUM(employee_payrolls.non_tax_other) as annual_non_tax_other,SUM(employee_payrolls.cola_amount) as annual_cola_amount,SUM(employee_payrolls.work_days_amount) as annual_work_days_amount,SUM(employee_payrolls.witholding_tax) as annual_witholding_tax,SUM(employee_payrolls.hdmf_contribution) as annual_hdmf,SUM(employee_payrolls.rest_special) as rest_special_hours,SUM(employee_payrolls.non_tax_other) as non_tax,SUM(employee_payrolls.sick_leave_amount) as leave_amount,employee_payrolls.department'))
//            ->groupBy('employee_code','employees.tin_number','employee_payrolls.department','employees.custom_thirteen')
//            ->get();
//
//        return $sample;
//
//    }

    public function thirteenMonth()
    {
        $thirteen = Employee_Payrolls::where('employee_code',1)->whereBetween('employee_payrolls.date_from',['201-12-1','2019-11-25']);
        return $thirteen;
    }

}
