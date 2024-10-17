<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $table = 'departments';
    protected $fillable = [
        'department_name',
        'department_code',
        'description',
        'department_address',
        'generated_code',
        'employer_tin',
        'employer_sss',
        'tel_no',
        'zip_code',
        'date_from',
        'date_to',
        'payroll_type'
    ];
    public function employee()
    {
        return $this->hasMany(Employee::class, 'department', 'department_name');
    }
    public function sub_department()
    {
        return $this->hasMany(Sub_Department::class,'department_code','generated_code');
    }
    public function employee_payroll()
    {
        return $this->hasMany(Employee_Payrolls::class,'department_code','department');
    }
}
