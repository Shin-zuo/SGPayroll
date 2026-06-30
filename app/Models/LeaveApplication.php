<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LeaveApplication extends Model
{
    protected $table = 'leave_applications';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'date_from',
        'date_to',
        'total_days',
        'reason',
        'status',
        'admin_remarks',
        'approved_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
