<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveCreditLedger extends Model
{
    protected $table = 'leave_credit_ledgers';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'year',
        'credit_limit',
        'used_days'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getRemainingDaysAttribute()
    {
        return max(0, $this->credit_limit - $this->used_days);
    }
}
