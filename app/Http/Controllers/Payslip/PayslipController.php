<?php

namespace SGpayroll\Http\Controllers\Payslip;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use SGpayroll\Department;
use SGpayroll\Employee;
use SGpayroll\Employee_Payrolls;
use SGpayroll\Employee_Loan;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Payroll_Employee;

class PayslipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $department = Department::orderBy('department_name', 'ASC')->get();

        $query = Employee_Payrolls::with(['departments', 'employee'])
            ->orderBy('id', 'DESC');

        // Filter by Search (Employee Name, Code, ID, or Department)
        if ($request->has('search') && trim($request->input('search')) !== '') {
            $search = trim($request->input('search'));
            $matchingEmployees = Employee::where('employee_Fname', 'like', "%{$search}%")
                ->orWhere('employee_Lname', 'like', "%{$search}%")
                ->orWhere('employee_id', 'like', "%{$search}%")
                ->get();
            $matchingIds = $matchingEmployees->pluck('id')->toArray();
            $matchingCodes = $matchingEmployees->pluck('employee_id')->filter()->toArray();
            $allEmpMatches = array_unique(array_merge($matchingIds, $matchingCodes));

            $query->where(function ($q) use ($search, $allEmpMatches) {
                if (!empty($allEmpMatches)) {
                    $q->whereIn('employee_code', $allEmpMatches)
                      ->orWhereIn('employee_id', $allEmpMatches);
                }
                $q->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        // Filter by Month
        if ($request->has('month') && $request->input('month') !== '' && $request->input('month') !== 'all') {
            $query->where('monthly_record', (int) $request->input('month'));
        }

        // Filter by Year
        if ($request->has('year') && $request->input('year') !== '' && $request->input('year') !== 'all') {
            $query->where('year', (int) $request->input('year'));
        }

        // Filter by Department
        if ($request->has('dept') && $request->input('dept') !== '' && $request->input('dept') !== 'all') {
            $query->where('department', $request->input('dept'));
        }

        $availableYears = Employee_Payrolls::select('year')
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();

        $currentYear = Carbon::now()->year;
        if (!in_array($currentYear, $availableYears)) {
            array_unshift($availableYears, $currentYear);
        }

        $totalPayslips = Employee_Payrolls::count();
        $payrolls = $query->paginate(15)->appends($request->except('page'));

        return view('payslip.index', compact('department', 'payrolls', 'availableYears', 'totalPayslips'));
    }

    public function viewPayslip(Request $request)
    {
        $this->validate($request, [
            'department' => 'required'
        ]);

        $department = Department::orderBy('department_name', 'DESC')->get();
        if ($request->has('department') && $request->has('employee_id')) {
            $payslip = Employee_Payrolls::whereYear('date_to', Carbon::parse($request['date_payslip'])->year)
                ->where('monthly_record', Carbon::parse($request['date_payslip'])->month)
                ->where('department', '=', $request['department'])
                ->where('employee_code', '=', $request['employee_id'])
                ->where('payroll_number', '=', $request['payroll_number'])
                ->get();
        }
        if ($request->has('department') && $request->has('print_all')) {
            $payslip = Employee_Payrolls::whereYear('date_to', Carbon::parse($request['date_payslip'])->year)
                ->where('monthly_record', Carbon::parse($request['date_payslip'])->month)
                ->where('department', '=', $request['department'])
                ->where('payroll_number', '=', $request['payroll_number'])
                ->get();
        }

        $data = [
            'department' => $department,
            'payslip' => $payslip
        ];

        $pdf = PDF::loadView('payslip.print', $data);
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="payslip.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function printSinglePayslip($id)
    {
        $payslipRecord = Employee_Payrolls::with(['departments', 'employee'])->findOrFail($id);
        $department = Department::orderBy('department_name', 'DESC')->get();
        $payslip = collect([$payslipRecord]);
        $data = [
            'department' => $department,
            'payslip' => $payslip
        ];

        $pdf = PDF::loadView('payslip.print', $data);
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="payslip-' . $payslipRecord->id . '.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $payslip = Employee_Payrolls::findOrFail($id);

            // Find the employee associated with this payslip
            $employee = null;
            if (!empty($payslip->employee_id)) {
                $employee = Employee::find($payslip->employee_id);
            }
            if (!$employee && !empty($payslip->employee_code)) {
                $employee = Employee::find($payslip->employee_code)
                         ?: Employee::where('employee_id', $payslip->employee_code)->first();
            }

            $revertedLoans = [];

            if ($employee) {
                // Map loan types to payslip deduction columns
                $loanMap = [
                    1 => 'sss_loan',
                    2 => 'sss_calamity_loan',
                    3 => 'hdmf_loan',
                    8 => 'hdmf_calamity_loan',
                    5 => 'other_loan',
                    6 => 'insurance',
                    7 => 'sss_emergency_loan',
                ];

                foreach ($loanMap as $type => $column) {
                    $deductedAmount = floatval($payslip->$column);
                    if ($deductedAmount > 0) {
                        $loan = Employee_Loan::where(function ($q) use ($employee) {
                                    $q->where('employee_id', $employee->id)
                                      ->orWhere('employee_code', $employee->employee_id);
                                })
                                ->where('loan_type', $type)
                                ->first();

                        if ($loan) {
                            $loan->remaining_term = $loan->remaining_term + 1;
                            $loan->balance = $loan->balance + $deductedAmount;
                            $loan->save();

                            $revertedLoans[] = "Loan type {$type} (+1 term, +₱" . number_format($deductedAmount, 2) . ")";
                        }
                    }
                }
            }

            $deletedId = $payslip->id;
            $payslip->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Payslip #{$deletedId} deleted successfully." . (count($revertedLoans) > 0 ? " Reverted loans: " . implode(', ', $revertedLoans) : "")
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payslip: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $payslip = Employee_Payrolls::with(['departments', 'employee'])->findOrFail($id);
        $emp = $payslip->employee;
        $empName = $emp ? $emp->full_name : ('Employee #' . $payslip->employee_code);
        $empCode = $emp ? $emp->employee_id : $payslip->employee_code;

        return response()->json([
            'success' => true,
            'payslip' => $payslip,
            'employee_name' => $empName,
            'employee_code' => $empCode,
            'department_name' => $payslip->department,
            'payroll_number' => $payslip->payroll_number,
            'period_text' => Carbon::parse($payslip->date_from)->format('M d, Y') . ' - ' . Carbon::parse($payslip->date_to)->format('M d, Y'),
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $payslip = Employee_Payrolls::findOrFail($id);

            // Find employee
            $employee = null;
            if (!empty($payslip->employee_id)) {
                $employee = Employee::find($payslip->employee_id);
            }
            if (!$employee && !empty($payslip->employee_code)) {
                $employee = Employee::find($payslip->employee_code)
                         ?: Employee::where('employee_id', $payslip->employee_code)->first();
            }

            // 1. Handle loan deduction adjustments
            $loanUpdates = [];
            if ($employee) {
                $loanMap = [
                    1 => 'sss_loan',
                    2 => 'sss_calamity_loan',
                    3 => 'hdmf_loan',
                    8 => 'hdmf_calamity_loan',
                    5 => 'other_loan',
                    6 => 'insurance',
                    7 => 'sss_emergency_loan',
                ];

                foreach ($loanMap as $type => $column) {
                    if ($request->has($column)) {
                        $oldDeduction = floatval($payslip->$column);
                        $newDeduction = floatval($request->input($column, 0));

                        if (abs($newDeduction - $oldDeduction) > 0.001) {
                            $loan = Employee_Loan::where(function ($q) use ($employee) {
                                        $q->where('employee_id', $employee->id)
                                          ->orWhere('employee_code', $employee->employee_id);
                                    })
                                    ->where('loan_type', $type)
                                    ->first();

                            if ($loan) {
                                $delta = $newDeduction - $oldDeduction;
                                $loan->balance = $loan->balance - $delta;

                                if ($oldDeduction <= 0 && $newDeduction > 0) {
                                    $loan->remaining_term = max(0, $loan->remaining_term - 1);
                                } elseif ($oldDeduction > 0 && $newDeduction <= 0) {
                                    $loan->remaining_term = $loan->remaining_term + 1;
                                }

                                $loan->save();
                                $loanUpdates[] = "Type {$type} (Δ ₱" . number_format($delta, 2) . ")";
                            }
                        }
                    }
                }
            }

            // 2. Extract and sanitize earnings
            $workDays               = floatval($request->input('work_days', $payslip->work_days));
            $workDaysAmount         = floatval($request->input('work_days_amount', $payslip->work_days_amount));
            $overtime               = floatval($request->input('overtime', $payslip->overtime));
            $overtimeAmount         = floatval($request->input('overtime_amount', $payslip->overtime_amount));
            $extRegHrs              = floatval($request->input('ext_reg_hrs', $payslip->ext_reg_hrs));
            $extRegHrsAmount        = floatval($request->input('ext_reg_hrs_ammount', $payslip->ext_reg_hrs_ammount));
            $nightDiff              = floatval($request->input('night_diff', $payslip->night_diff));
            $nightDiffAmount        = floatval($request->input('night_diff_amount', $payslip->night_diff_amount));
            $nightDiffRestday       = floatval($request->input('night_diff_restday', $payslip->night_diff_restday));
            $nightDiffRestdayAmount = floatval($request->input('night_diff_restday_amount', $payslip->night_diff_restday_amount));
            $restSpecial            = floatval($request->input('rest_special', $payslip->rest_special));
            $restSpecialAmount      = floatval($request->input('rest_special_amount', $payslip->rest_special_amount));
            $excRestSpecial         = floatval($request->input('exc_rest_special', $payslip->exc_rest_special));
            $excRestSpecialAmount   = floatval($request->input('exc_rest_special_amount', $payslip->exc_rest_special_amount));
            $regHoliday             = floatval($request->input('regular_holiday', $payslip->regular_holiday));
            $regHolidayAmount       = floatval($request->input('regular_holiday_amount', $payslip->regular_holiday_amount));
            $excRegHoliday          = floatval($request->input('exc_regular_holiday', $payslip->exc_regular_holiday));
            $excRegHolidayAmount    = floatval($request->input('exc_regular_holiday_amount', $payslip->exc_regular_holiday_amount));
            $regHolidayDayAmount    = floatval($request->input('regular_holiday_day_amount', $payslip->regular_holiday_day_amount));
            $specialHolidayAmount   = floatval($request->input('special_holiday_day_amount', $payslip->special_holiday_day_amount));
            $sickLeaveAmount        = floatval($request->input('sick_leave_amount', $payslip->sick_leave_amount));
            $vacationLeaveAmount    = floatval($request->input('vacation_leave_amount', $payslip->vacation_leave_amount));
            $colaAmount             = floatval($request->input('cola_amount', $payslip->cola_amount));
            $nonTaxOther            = floatval($request->input('non_tax_other', $payslip->non_tax_other));
            $regularOther           = floatval($request->input('regular_other', $payslip->regular_other));
            $commission             = floatval($request->input('commission', $payslip->commission));
            $hazardPay              = floatval($request->input('hazard_pay', $payslip->hazard_pay));

            // Compute total gross pay
            $calculatedGross = $workDaysAmount + $overtimeAmount + $extRegHrsAmount + $nightDiffAmount
                + $nightDiffRestdayAmount + $restSpecialAmount + $excRestSpecialAmount + $regHolidayAmount
                + $excRegHolidayAmount + $regHolidayDayAmount + $specialHolidayAmount + $sickLeaveAmount
                + $vacationLeaveAmount + $colaAmount + $nonTaxOther + $regularOther + $commission + $hazardPay;

            if ($request->has('gross_pay') && floatval($request->input('gross_pay')) > 0) {
                $grossPay = floatval($request->input('gross_pay'));
            } else {
                $grossPay = $calculatedGross;
            }

            // 3. Extract and sanitize deductions
            $witholdingTax      = floatval($request->input('witholding_tax', $payslip->witholding_tax));
            $sssContribution    = floatval($request->input('sss_contribution', $payslip->sss_contribution));
            $providentFund      = floatval($request->input('provident_fund', $payslip->provident_fund));
            $phicContribution   = floatval($request->input('phic_contribution', $payslip->phic_contribution));
            $hdmfContribution   = floatval($request->input('hdmf_contribution', $payslip->hdmf_contribution));
            $insurance          = floatval($request->input('insurance', $payslip->insurance));
            $sssLoan            = floatval($request->input('sss_loan', $payslip->sss_loan));
            $sssCalamityLoan    = floatval($request->input('sss_calamity_loan', $payslip->sss_calamity_loan));
            $hdmfLoan           = floatval($request->input('hdmf_loan', $payslip->hdmf_loan));
            $hdmfCalamityLoan   = floatval($request->input('hdmf_calamity_loan', $payslip->hdmf_calamity_loan));
            $otherLoan          = floatval($request->input('other_loan', $payslip->other_loan));
            $sssEmergencyLoan   = floatval($request->input('sss_emergency_loan', $payslip->sss_emergency_loan));
            $companyLoan        = floatval($request->input('company_loan', $payslip->company_loan));
            $rent               = floatval($request->input('rent', $payslip->rent));

            $calculatedDeductions = $witholdingTax + $sssContribution + $providentFund + $phicContribution
                + $hdmfContribution + $insurance + $sssLoan + $sssCalamityLoan + $hdmfLoan + $hdmfCalamityLoan
                + $otherLoan + $sssEmergencyLoan + $companyLoan + $rent;

            if ($request->has('total_deduction') && floatval($request->input('total_deduction')) > 0) {
                $totalDeduction = floatval($request->input('total_deduction'));
            } else {
                $totalDeduction = $calculatedDeductions;
            }

            $netPay = max(0, $grossPay - $totalDeduction);

            // 4. Update payslip record
            $payslip->update([
                'work_days'                  => $workDays,
                'work_days_amount'           => $workDaysAmount,
                'overtime'                   => $overtime,
                'overtime_amount'            => $overtimeAmount,
                'ext_reg_hrs'                => $extRegHrs,
                'ext_reg_hrs_ammount'        => $extRegHrsAmount,
                'night_diff'                 => $nightDiff,
                'night_diff_amount'          => $nightDiffAmount,
                'night_diff_restday'         => $nightDiffRestday,
                'night_diff_restday_amount'  => $nightDiffRestdayAmount,
                'rest_special'               => $restSpecial,
                'rest_special_amount'        => $restSpecialAmount,
                'exc_rest_special'           => $excRestSpecial,
                'exc_rest_special_amount'    => $excRestSpecialAmount,
                'regular_holiday'            => $regHoliday,
                'regular_holiday_amount'     => $regHolidayAmount,
                'exc_regular_holiday'        => $excRegHoliday,
                'exc_regular_holiday_amount' => $excRegHolidayAmount,
                'regular_holiday_day_amount' => $regHolidayDayAmount,
                'special_holiday_day_amount' => $specialHolidayAmount,
                'sick_leave_amount'          => $sickLeaveAmount,
                'vacation_leave_amount'      => $vacationLeaveAmount,
                'cola_amount'                => $colaAmount,
                'non_tax_other'              => $nonTaxOther,
                'regular_other'              => $regularOther,
                'commission'                 => $commission,
                'hazard_pay'                 => $hazardPay,
                'gross_pay'                  => $grossPay,
                'witholding_tax'             => $witholdingTax,
                'sss_contribution'           => $sssContribution,
                'provident_fund'             => $providentFund,
                'phic_contribution'          => $phicContribution,
                'hdmf_contribution'          => $hdmfContribution,
                'insurance'                  => $insurance,
                'sss_loan'                   => $sssLoan,
                'sss_calamity_loan'          => $sssCalamityLoan,
                'hdmf_loan'                  => $hdmfLoan,
                'hdmf_calamity_loan'         => $hdmfCalamityLoan,
                'other_loan'                 => $otherLoan,
                'sss_emergency_loan'         => $sssEmergencyLoan,
                'company_loan'               => $companyLoan,
                'rent'                       => $rent,
                'total_deduction'            => $totalDeduction,
                'net_pay'                    => $netPay,
            ]);

            DB::commit();

            return response()->json([
                'success'           => true,
                'message'           => "Payslip #{$id} updated successfully." . (count($loanUpdates) > 0 ? " (" . implode(', ', $loanUpdates) . ")" : ""),
                'gross_pay'         => number_format($grossPay, 2),
                'total_deduction'   => number_format($totalDeduction, 2),
                'net_pay'           => number_format($netPay, 2),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payslip: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showDataPayslip(Request $request)
    {
        $query = Employee::where("department", "=", $request['group_id']);

        if ($request->has('status') && $request['status'] !== '' && $request['status'] !== 'all') {
            $query->where('employee_status', '=', $request['status']);
        }

        $sub_group = $query->orderBy('employee_Lname', 'ASC')->get();
        return response()->json($sub_group);
    }
}
