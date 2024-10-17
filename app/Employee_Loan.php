<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Employee_Loan extends Model
{
    //
    protected $table = 'employee_loans';
    protected $fillable = [
        'employee_code',
        'employee_id',
        'loan_type',
        'loan_name',
        'sss_loan_type',
        'promissory_note',
        'loan_date',
        'loan_amount',
        'semester',
        'deduction',
        'deduction_date',
        'balance',
        'interest',
        'remaining_term',
        'original_term',
        'total_laon',
        'active'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
