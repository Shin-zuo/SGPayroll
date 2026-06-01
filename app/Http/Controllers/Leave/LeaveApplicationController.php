<?php

namespace SGpayroll\Http\Controllers\Leave;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\LeaveApplication;
use SGpayroll\LeaveCreditLedger;

class LeaveApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Admin view for all leave applications
        $applications = LeaveApplication::with(['employee', 'approver'])->orderBy('created_at', 'DESC')->get();

        // Calculate balances to pass to the view so it can disable the Approve button
        $applications->map(function($app) {
            $year = \Carbon\Carbon::parse($app->date_from)->year;
            $ledger = LeaveCreditLedger::where('employee_id', $app->employee_id)
                ->where('leave_type', $app->leave_type)
                ->where('year', $year)
                ->first();
                
            if ($ledger) {
                $app->remaining = max(0, $ledger->credit_limit - $ledger->used_days);
            } else {
                $app->remaining = 0;
            }
            $app->can_approve = $app->remaining >= $app->total_days;
            return $app;
        });

        return view('leave.index', compact('applications'));
    }

    public function approve(Request $request, $id)
    {
        $app = LeaveApplication::findOrFail($id);
        
        if ($app->status !== 'pending') {
            return back()->with('error', 'Only pending applications can be approved.');
        }

        $year = \Carbon\Carbon::parse($app->date_from)->year;
        $ledger = LeaveCreditLedger::firstOrCreate(
            [
                'employee_id' => $app->employee_id,
                'leave_type' => $app->leave_type,
                'year' => $year
            ]
        );

        $remaining = max(0, $ledger->credit_limit - $ledger->used_days);

        if ($app->total_days > $remaining) {
            return back()->with('error', 'Insufficient leave credits to approve this application.');
        }

        // Approve and consume
        $app->status = 'approved';
        $app->approved_by = auth()->id();
        $app->admin_remarks = 'Approved by admin';
        $app->save();

        $ledger->used_days += $app->total_days;
        $ledger->save();

        return back()->with('success', 'Leave application approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $app = LeaveApplication::findOrFail($id);
        
        if ($app->status !== 'pending') {
            return back()->with('error', 'Only pending applications can be rejected.');
        }

        $app->status = 'rejected';
        $app->approved_by = auth()->id();
        $app->admin_remarks = 'Rejected by admin';
        $app->save();

        return back()->with('success', 'Leave application rejected.');
    }

    // API Endpoint for Payroll Generator
    public function checkBalance($employee_id, $leave_type, $year)
    {
        $ledger = LeaveCreditLedger::where('employee_id', $employee_id)
                ->where('leave_type', $leave_type)
                ->where('year', $year)
                ->first();

        if (!$ledger) {
            return response()->json(['remaining' => 0]);
        }

        $remaining = max(0, $ledger->credit_limit - $ledger->used_days);
        return response()->json(['remaining' => $remaining]);
    }
}
