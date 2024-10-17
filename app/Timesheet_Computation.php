<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Timesheet_Computation extends Model
{
    //
    protected $table = 'timesheet_computations';
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
