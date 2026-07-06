<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class LeaveWindowSetting extends Model
{
    protected $table = 'leave_window_settings';

    protected $fillable = [
        'is_open',
        'opened_by',
        'opened_at',
        'closed_by',
        'closed_at',
    ];

    protected $dates = ['opened_at', 'closed_at'];

    /**
     * Get the single settings row, creating it if it doesn't exist.
     */
    public static function current()
    {
        return static::firstOrCreate([], [
            'is_open' => 0,
        ]);
    }

    /**
     * Check if the leave window is currently open.
     * True if either:
     *  1. Today is December 14–31 (auto window), OR
     *  2. Super admin has manually toggled it open.
     */
    public static function isOpen()
    {
        $today = \Carbon\Carbon::now();
        $isDecemberWindow = ($today->month === 12 && $today->day >= 14);

        if ($isDecemberWindow) {
            return true;
        }

        return (bool) static::current()->is_open;
    }
}
