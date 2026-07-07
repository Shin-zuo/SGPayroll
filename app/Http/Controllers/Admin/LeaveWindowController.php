<?php

namespace SGpayroll\Http\Controllers\Admin;

use Illuminate\Http\Request;
use SGpayroll\Employee;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\LeaveCreditLedger;
use SGpayroll\LeaveWindowSetting;

class LeaveWindowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'superadmin']);
    }

    /**
     * Manually open the leave credit window (emergency/override).
     */
    public function open()
    {
        $setting = LeaveWindowSetting::current();
        $setting->update([
            'is_open'   => 1,
            'opened_by' => auth()->id(),
            'opened_at' => \Carbon\Carbon::now(),
        ]);

        return back()->with('success', 'Leave credit window has been manually OPENED.');
    }

    /**
     * Manually close the leave credit window.
     */
    public function close()
    {
        $setting = LeaveWindowSetting::current();
        $setting->update([
            'is_open'   => 0,
            'closed_by' => auth()->id(),
            'closed_at' => \Carbon\Carbon::now(),
        ]);

        return back()->with('success', 'Leave credit window has been manually CLOSED.');
    }

    /**
     * Reset the leave credit lock for a specific employee and year,
     * allowing the admin to re-edit even after it was saved.
     */
    public function resetEmployeeLock(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'year'        => 'required|integer|min:2000|max:2100',
        ]);

        LeaveCreditLedger::where('employee_id', $request->employee_id)
            ->where('year', $request->year)
            ->update(['locked_at' => null]);

        return back()->with('success', 'Leave credit lock reset for employee #' . $request->employee_id . ' (' . $request->year . ').');
    }

    /**
     * Super Admin dashboard: shows window status + employee lock states.
     */
    public function index()
    {
        $setting      = LeaveWindowSetting::current();
        $isAutoOpen   = (\Carbon\Carbon::now()->month === 12 && \Carbon\Carbon::now()->day >= 14);
        $isManualOpen = (bool) $setting->is_open;
        $currentYear  = \Carbon\Carbon::now()->year;

        // Load all employees with their leave lock status for the current year
        $employees = Employee::orderBy('employee_Lname')
            ->where('employee_status', '1')
            ->with(['leave_credit_ledgers' => function ($q) use ($currentYear) {
                $q->where('year', $currentYear);
            }])
            ->get()
            ->map(function ($emp) use ($currentYear) {
                $vacationLedger = $emp->leave_credit_ledgers->where('leave_type', 'vacation')->first();
                $sickLedger     = $emp->leave_credit_ledgers->where('leave_type', 'sick')->first();

                $emp->vacation_locked = $vacationLedger && $vacationLedger->locked_at !== null;
                $emp->sick_locked     = $sickLedger && $sickLedger->locked_at !== null;
                $emp->leave_set       = $emp->vacation_locked || $emp->sick_locked;

                return $emp;
            });

        return view('admin.superadmin', compact(
            'setting',
            'isAutoOpen',
            'isManualOpen',
            'currentYear',
            'employees'
        ));
    }
}
