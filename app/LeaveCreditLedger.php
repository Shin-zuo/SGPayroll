<?php

namespace SGpayroll;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LeaveCreditLedger extends Model
{
    protected $table = 'leave_credit_ledgers';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'year',
        'credit_limit',
        'used_days',
        'locked_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getRemainingDaysAttribute()
    {
        return max(0, $this->credit_limit - $this->used_days);
    }

    /**
     * Reload annual leave credits for all active employees to 11 (6 VL, 5 SL).
     * Standard annual feature that resets leave credits starting the 2nd week of December (Dec 14+).
     *
     * @param int|null $year
     * @return int Count of employees updated
     */
    public static function reloadAnnualCredits($year = null)
    {
        $year = $year ?: Carbon::now()->year;
        $activeEmployees = Employee::where('employee_status', '1')->get();
        $updatedCount = 0;

        foreach ($activeEmployees as $emp) {
            // Vacation Leave: 6 days
            static::updateOrCreate(
                [
                    'employee_id' => $emp->id,
                    'leave_type'  => 'vacation',
                    'year'        => $year,
                ],
                [
                    'credit_limit' => 6,
                    'used_days'    => 0,
                    'locked_at'    => null,
                ]
            );

            // Sick Leave: 5 days
            static::updateOrCreate(
                [
                    'employee_id' => $emp->id,
                    'leave_type'  => 'sick',
                    'year'        => $year,
                ],
                [
                    'credit_limit' => 5,
                    'used_days'    => 0,
                    'locked_at'    => null,
                ]
            );

            // Synchronize with employee table
            $emp->update([
                'leave'      => 6,
                'sick_leave' => 5,
            ]);

            $updatedCount++;
        }

        return $updatedCount;
    }
}
