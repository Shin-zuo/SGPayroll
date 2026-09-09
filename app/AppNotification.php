<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppNotification extends Model
{
    protected $table = 'app_notifications';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Send notification to all HR / Admin accounts (user_type 0 and 1).
     */
    public static function notifyAdmins($title, $message, $type, $link = null)
    {
        $admins = User::whereIn('user_type', [0, 1])->get();
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'link' => $link,
                'is_read' => false,
            ]);
        }
    }

    /**
     * Send notification strictly to the specific employee's user account.
     */
    public static function notifyEmployee($employeeIdentifier, $title, $message, $type, $link = null)
    {
        if (empty($employeeIdentifier)) {
            return null;
        }

        $user = null;

        // 1. If passed an Employee model instance
        if ($employeeIdentifier instanceof Employee) {
            $user = User::where('employee_id', $employeeIdentifier->id)->first();
        }
        // 2. If passed a User model instance
        elseif ($employeeIdentifier instanceof User) {
            $user = $employeeIdentifier;
        }
        // 3. Try to resolve if $employeeIdentifier is numeric or string
        else {
            // Check if it's the employees.employee_id string (emp code e.g. '134861', '66', '78')
            $empByCode = Employee::where('employee_id', (string)$employeeIdentifier)->first();
            if ($empByCode) {
                $user = User::where('employee_id', $empByCode->id)->first();
            }

            // Check if it matches users.employee_id directly (which stores employees.id)
            if (!$user) {
                $user = User::where('employee_id', $employeeIdentifier)->first();
            }

            // Check if it matches employees.id
            if (!$user) {
                $empById = Employee::find($employeeIdentifier);
                if ($empById) {
                    $user = User::where('employee_id', $empById->id)->first();
                }
            }
        }

        // STRICT ACCOUNT SCOPING:
        // Must resolve to an existing User account, and user_id is strictly set to that user.
        if ($user && !empty($user->id)) {
            return self::create([
                'user_id' => $user->id,
                'title'   => $title,
                'message' => $message,
                'type'    => $type,
                'link'    => $link,
                'is_read' => false,
            ]);
        }

        return null;
    }

    /**
     * Human-friendly relative timestamp accessor.
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : '';
    }
}
