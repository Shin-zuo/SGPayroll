<?php

namespace SGpayroll\Http\Controllers\Portal;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\LeaveCreditLedger;
use SGpayroll\LeaveApplication;
use SGpayroll\Employee_Payrolls;
use PDF;
use Carbon\Carbon;

class PortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $employee_id = auth()->user()->employee_id;
        $applications = LeaveApplication::where('employee_id', $employee_id)->orderBy('created_at', 'DESC')->take(5)->get();
        
        $recentPayslips = Employee_Payrolls::where('employee_code', $employee_id)->orderBy('id', 'DESC')->take(5)->get();
        if ($recentPayslips->isEmpty()) {
            $recentPayslips = Employee_Payrolls::where('employee_id', $employee_id)->orderBy('id', 'DESC')->take(5)->get(); // fallback
        }
        
        $year = Carbon::now()->year;
        $ledgers = LeaveCreditLedger::where('employee_id', $employee_id)->where('year', $year)->get();
        $vacation = $ledgers->where('leave_type', 'vacation')->first();
        $sick = $ledgers->where('leave_type', 'sick')->first();
        $vacation_remaining = $vacation ? max(0, $vacation->credit_limit - $vacation->used_days) : 0;
        $sick_remaining = $sick ? max(0, $sick->credit_limit - $sick->used_days) : 0;
        $total_leave_balance = $vacation_remaining + $sick_remaining;

        $payrollsYTD = Employee_Payrolls::where('employee_code', $employee_id)->where('year', $year)->get();
        if ($payrollsYTD->isEmpty()) {
            $payrollsYTD = Employee_Payrolls::where('employee_id', $employee_id)->where('year', $year)->get();
        }
        
        $total_contributions = [
            'sss' => $payrollsYTD->sum('sss_contribution'),
            'philhealth' => $payrollsYTD->sum('phic_contribution'),
            'pagibig' => $payrollsYTD->sum('hdmf_contribution'),
        ];
        
        return view('portal.index', compact('applications', 'recentPayslips', 'total_leave_balance', 'total_contributions'));
    }

    public function leaveBalance()
    {
        $year = Carbon::now()->year;
        $employee_id = auth()->user()->employee_id;
        $ledgers = LeaveCreditLedger::where('employee_id', $employee_id)->where('year', $year)->get();

        $vacation = $ledgers->where('leave_type', 'vacation')->first();
        $sick = $ledgers->where('leave_type', 'sick')->first();

        $vacation_remaining = $vacation ? max(0, $vacation->credit_limit - $vacation->used_days) : 0;
        $sick_remaining = $sick ? max(0, $sick->credit_limit - $sick->used_days) : 0;

        // Fetch ALL leave applications (all statuses) for this employee
        $applications = LeaveApplication::where('employee_id', $employee_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('portal.leave-balance', compact('vacation', 'sick', 'vacation_remaining', 'sick_remaining', 'year', 'applications'));
    }


    public function applyLeave(Request $request)
    {
        $employee_id = auth()->user()->employee_id;
        
        // Calculate days (simple inclusive calculation)
        $from = Carbon::parse($request->date_from);
        $to = Carbon::parse($request->date_to);
        $days = $from->diffInDays($to) + 1; // Assuming weekends count, can be refined.

        LeaveApplication::create([
            'employee_id' => $employee_id,
            'leave_type' => $request->leave_type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'total_days' => $days,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Leave application submitted successfully.');
    }

    public function payslips()
    {
        $employee_id = auth()->user()->employee_id;
        $payrolls = Employee_Payrolls::where('employee_code', $employee_id)->orderBy('id', 'DESC')->get();
        if ($payrolls->isEmpty()) {
            $payrolls = Employee_Payrolls::where('employee_id', $employee_id)->orderBy('id', 'DESC')->get();
        }
        return view('portal.payslips', compact('payrolls'));
    }

    public function downloadPayslip($id)
    {
        $employee_id = auth()->user()->employee_id;
        $payroll = Employee_Payrolls::where('id', $id)
                 ->where(function($query) use ($employee_id) {
                     $query->where('employee_code', $employee_id)
                           ->orWhere('employee_id', $employee_id);
                 })
                 ->firstOrFail();

        $data = ['payroll' => $payroll];
        $pdf = PDF::loadView('portal.payslip-pdf', $data);
        return $pdf->download("payslip-{$payroll->date_from}-to-{$payroll->date_to}.pdf");
    }

    public function contributions()
    {
        $employee_id = auth()->user()->employee_id;
        
        // Let's get contributions grouped by year to show history
        $payrolls = Employee_Payrolls::where('employee_code', $employee_id)->orderBy('date_from', 'DESC')->get();
        if ($payrolls->isEmpty()) {
            $payrolls = Employee_Payrolls::where('employee_id', $employee_id)->orderBy('date_from', 'DESC')->get();
        }

        $yearlyContributions = [];
        foreach ($payrolls as $payroll) {
            $year = Carbon::parse($payroll->date_from)->year;
            if (!isset($yearlyContributions[$year])) {
                $yearlyContributions[$year] = ['sss' => 0, 'philhealth' => 0, 'pagibig' => 0];
            }
            $yearlyContributions[$year]['sss'] += $payroll->sss_contribution;
            $yearlyContributions[$year]['philhealth'] += $payroll->phic_contribution;
            $yearlyContributions[$year]['pagibig'] += $payroll->hdmf_contribution;
        }

        return view('portal.contributions', compact('yearlyContributions', 'payrolls'));
    }
}
