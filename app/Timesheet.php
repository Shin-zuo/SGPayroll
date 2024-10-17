<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    //
    protected $table = 'timesheet';
    protected $fillable = [
        'employee_code',
        'time_in',
        'time_out',
        'date_log',
        'duration'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
