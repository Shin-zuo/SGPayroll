<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Payroll_Timesheet extends Model
{
    //
    protected $table = 'payroll_timesheet';
    protected $fillable = [
        'employee_code',
        'time_in',
        'time_out',
        'date_log',

    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
