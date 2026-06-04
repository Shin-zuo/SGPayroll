<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employees';
    protected $fillable = [
        'employee_id',
        'employee_status',
        'payroll_type',
        'categories',
        'salary_status',
        'custom_thirteen',
        'basic_pay',
        'other_nt_pay',
        'cola',
        'leave',
        'sick_leave',
        'pag_ibig_contribution',
        'pagibig_amount',
        'loan',
        'tax_status',
        'sss_status',
        'phic_status',
        'sss_loan_deduction',
        'pagibig_loan_deduction',
        'company_loan_deduction',
        'union',
        'employee_Fname',
        'employee_Lname',
        'employee_Mname',
        'date_hired',
        'birth_day',
        'gender',
        'position',
        'department',
        'address',
        'email',
        'contactName',
        'contactNo',
        'employment_status',
        'employment_date_from',
        'employment_date_to',
        'status',
        'sss_number',
        'tin_number',
        'hdmf_number',
        'ucpb_number',
        'philhealth_number',
        'passport_number',
        'passport_exp',
<<<<<<< HEAD
=======
        'profile_picture',
>>>>>>> branch1
    ];
    public function getFullNameAttribute()
    {
        return ucfirst($this->employee_Lname) . ', ' . ucfirst($this->employee_Fname) .' '. ucfirst(substr($this->employee_Mname,0,1)) . '.';
    }
    public function payroll_timesheet()
    {
        return $this->hasMany(Payroll_Timesheet::class,'employee_code','employee_id');
    }
    public function timesheet_computation()
    {
        return $this->hasMany(Timesheet_Computation::class,'employee_code','employee_id');
    }
    public function timesheet()
    {
        return $this->hasMany(Timesheet::class,'employee_code','employee_id');
    }
    public function payroll_employee()
    {
        return $this->hasMany(Payroll_Employee::class,'employee_code','employee_id');
    }
    public function employee_loans()
    {
        return $this->hasMany(Employee_Loan::class,'employee_code','employee_id');
    }
    public function employee_payroll()
    {
        return $this->belongsTo(Employee_Payrolls::class);
    }
    public function departments()
    {
        return $this->belongsTo(Department::class,'department','department_code');
    }
<<<<<<< HEAD
=======

    public function leave_credit_ledgers()
    {
        return $this->hasMany(LeaveCreditLedger::class, 'employee_id');
    }

    public function leave_applications()
    {
        return $this->hasMany(LeaveApplication::class, 'employee_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
>>>>>>> branch1
}
