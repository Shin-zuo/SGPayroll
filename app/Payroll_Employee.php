<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Payroll_Employee extends Model
{
    //
    protected $table = 'payroll_employees';
    protected $fillable = [
        'employee_code',
        'work_day',
        'overtime_pay',
        'holiday_pay',
        'leave_pay',
        'other_taxable_pay',
        'other_non_taxable_pay',
        'gross_pay',
        'witholding_tax',
        'sss_contribution',
        'phil_health_contribution',
        'pag_ibig_contribution',
        'union_contribution',
        'insurance_contribution',
        'sss_loans',
        'pag_ibig_loans',
        'other_loans',
        'net_pay',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
