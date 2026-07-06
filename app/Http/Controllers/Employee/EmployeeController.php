<?php

namespace SGpayroll\Http\Controllers\Employee;

use Excel;
use mysql_xdevapi\Session;
use SGpayroll\Department;
use SGpayroll\Employee;
use Illuminate\Http\Request;
use SGpayroll\Employee_Loan;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\LeaveCreditLedger;
use SGpayroll\LeaveWindowSetting;
use SGpayroll\Loan;
use SGpayroll\Pagibig_Table;
use SGpayroll\Payroll_Timesheet;
use SGpayroll\Sub_Department;
use SGpayroll\Timesheet_Computation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class EmployeeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Only admin/HR (user_type 1) can view employee list
        if (auth()->user()->user_type != 1) {
            return redirect('/portal');
        }

        // Fetch data for admin view
        $department = Department::orderBy('department_name','ASC')->get();
        $employee = Employee::orderBy('employee_Lname','ASC')->where('employee_status','1')->get();
        $data = [
            'department' => $department,
            'employee' => $employee,
        ];
        return view('employee.index')->with($data);
    }
    public function addEmployee(Request $request)
    {
//        dd($request);
        $employee = Employee::create(
            [
                'employee_id' => $request['employee_id'],
                'employee_status' => "1",
                'employee_Fname' => $request['employee_Fname'],
                'employee_Lname' => $request['employee_Lname'],
                'employee_Mname' => $request['employee_Mname'],
                'date_hired' => $request['date_hired'],
                'birth_day' => $request['birth_date'],
                'gender' => $request['gender'],
                'department' => $request['department'],
                'position' => $request['sub_department'],
                'status' => $request['status'],
                'address' => $request['address'],
                'email' => $request['emp_email'],
                'sss_number'=> $request['sss'],
                'tin_number' => $request['tin'],
                'hdmf_number' => $request['hdmf'],
                'philhealth_number' => $request['philhealth'],
                'ucpb_number' => $request['ucpb'],
                'passport_number' => $request['passport'],
                'passport_exp' => $request['passport_exp'],
            ]
        );

        if ($request['emp_email']) {
            \SGpayroll\User::firstOrCreate(
                ['email' => $request['emp_email']],
                [
                    'name'        => $employee->full_name,
                    'password'    => bcrypt('testPass'),
                    'user_type'   => 2,
                    'employee_id' => $employee->id,
                ]
            );
        }

        return response()->json(['success' => true]);
    }
    public function accountEmployee($id)
    {
        $department    = Department::orderBy('department_name', 'ASC')->get();
        $employee      = Employee::find($id);
        $currentYear   = Carbon::now()->year;
        $leaveWindowOpen = LeaveWindowSetting::isOpen();

        // Check if leave credit is already locked for this employee this year
        $vacationLedger = LeaveCreditLedger::where('employee_id', $id)
            ->where('leave_type', 'vacation')
            ->where('year', $currentYear)
            ->first();

        $sickLedger = LeaveCreditLedger::where('employee_id', $id)
            ->where('leave_type', 'sick')
            ->where('year', $currentYear)
            ->first();

        // Already set = at least one ledger row is locked
        $leaveAlreadySet = ($vacationLedger && $vacationLedger->locked_at)
                        || ($sickLedger && $sickLedger->locked_at);

        $vacationBalance = $vacationLedger ? max(0, $vacationLedger->credit_limit - $vacationLedger->used_days) : 0;
        $sickBalance     = $sickLedger     ? max(0, $sickLedger->credit_limit - $sickLedger->used_days)         : 0;

        $data = [
            'department'       => $department,
            'employee'         => $employee,
            'leaveWindowOpen'  => $leaveWindowOpen,
            'leaveAlreadySet'  => $leaveAlreadySet,
            'vacationBalance'  => $vacationBalance,
            'sickBalance'      => $sickBalance,
            'currentYear'      => $currentYear,
        ];

        return view('employee.account')->with($data);
    }
    public function updateAccount(Request $request)
    {
       Employee::find($request['id'])->update([
           'employee_id' => $request['employee_id'],
           'categories' => $request['categories'],
           'employee_Fname' => $request['employee_Fname'],
           'employee_Lname' => $request['employee_Lname'],
           'employee_Mname' => $request['employee_Mname'],
           'date_hired' => $request['date_hired'],
           'birth_day' => $request['birth_date'],
           'gender' => $request['gender'],
           'department' => $request['department'],
           'position' => $request['sub_department'],
           'status' => $request['status'],
           'address' => $request['address'],
           'email' => $request['email'],
           'contactName' => $request['contactName'],
           'contactNo' => $request['contactNo'],
           'employment_status' => $request['employment_status'],
           'employment_date_from' => $request['employment_date_from'],
           'employment_date_to' => $request['employment_date_to'],
           'sss_number'=> $request['sss'],
           'tin_number' => $request['tin'],
           'hdmf_number' => $request['hdmf'],
           'philhealth_number' => $request['philhealth'],
           'ucpb_number' => $request['ucpb'],
           'passport_number' => $request['passport'],
           'salary_status' => $request['salary_status'],
           'passport_exp' => $request['passport_exp'],
       ]);
       return 0;
    }
    public function destroy(Request $request)
    {
       Employee::find($request['id'])->update(["employee_status" => "2"]);
       return 0;
    }
    public function turnActive(Request $request)
    {
        Employee::find($request['id'])->update(["employee_status" => "1"]);
        return 0;
    }
    public function showData(Request $request)
    {
       $sub_group = Department::find($request['group_id'])->sub_department()->get();
       return $sub_group;
    }
    public function attendanceEmployee($id)
    {
        $time_sheet = Employee::find($id)->timesheet_computation()->get();

        $data = [
            "time_sheet" => $time_sheet,
        ];
            return view('employee.attendance')->with($data);
    }
    public function updateSalary(Request $request)
    {
        $year = Carbon::now()->year;

        // --- Leave window & lock guard ---
        if (!LeaveWindowSetting::isOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Leave credits are not editable at this time. The window opens Dec 14–31 or when opened by the Super Admin.'
            ], 403);
        }

        // Check if already locked for this year
        $vacationLocked = LeaveCreditLedger::where('employee_id', $request['employee_id'])
            ->where('leave_type', 'vacation')
            ->where('year', $year)
            ->whereNotNull('locked_at')
            ->exists();

        $sickLocked = LeaveCreditLedger::where('employee_id', $request['employee_id'])
            ->where('leave_type', 'sick')
            ->where('year', $year)
            ->whereNotNull('locked_at')
            ->exists();

        if ($vacationLocked || $sickLocked) {
            return response()->json([
                'success' => false,
                'message' => "Leave credits for {$year} have already been set and are locked. Contact the Super Admin to reset."
            ], 403);
        }
        // --- End guard ---

        Employee::find($request['employee_id'])->update([
            'basic_pay'    => $request['basic_pay'],
            'other_nt_pay' => $request['other_nt_pay'],
            'cola'         => $request['cola'],
            'payroll_type' => $request['payroll_type'],
            'leave'        => $request['leave'],
            'sick_leave'   => $request['sick'],
        ]);

        // Write leave credit ledger and lock it immediately
        $lockTime = now();

        LeaveCreditLedger::updateOrCreate(
            ['employee_id' => $request['employee_id'], 'leave_type' => 'vacation', 'year' => $year],
            ['credit_limit' => $request['leave'] ?: 0, 'locked_at' => $lockTime]
        );

        LeaveCreditLedger::updateOrCreate(
            ['employee_id' => $request['employee_id'], 'leave_type' => 'sick', 'year' => $year],
            ['credit_limit' => $request['sick'] ?: 0, 'locked_at' => $lockTime]
        );

        return response()->json(['success' => true, 'message' => 'Salary and leave credits updated successfully.']);
    }
    public function deductionEmployee(Request $request)
    {
//        dd($request);
        Employee::find($request['id'])->update([
            "sss_status" => $request['sss'],
            "tax_status" => $request['tax'],
            "phic_status" => $request['philhealth'],
            "pag_ibig_contribution" => $request['pagibig'],
            "pagibig_amount" => $request['pagibig_amount'],
        ]);
        return 0;
    }
    public function loansEmployee($id)
    {
        $employee = Employee::find($id);
        $employee_loan = Employee::find($id)->employee_loans()->get();
//        dd($employee_loan);
        $loan_type = Loan::all();
        $data = [
            "employee" => $employee,
            "loan_type" => $loan_type,
            "employee_loan" => $employee_loan,
        ];
        return view('employee.loans')->with($data);
    }
    public function loansEmployeeData(Request $request)
    {

        if($request['loan_type_name'] == "COMPANY LOAN")
        {
//            dd($request);
            $deduction_loan = $request['loan_amount'] / $request['semester'];
            Employee_Loan::create([
                "employee_code" => $request['employee_id'],
                "loan_date" => $request['loan_date'],
                "loan_type" => $request['loan_type_name'],
                "loan_amount" => $request['loan_amount'],
                "semester" => $request['semester'],
                "deduction" => $deduction_loan,
            ]);
        }
        return 0;

    }
    public function inactiveEmployee() {
        $inactive_employee = Employee::orderBy('employee_Lname','ASC')->where('employee_status',"2")->get();
        $data = [

            'inactive_employee' => $inactive_employee,
        ];
        return view('employee.inactive')->with($data);
    }
    public function uploadEmployee()
    {
        return view('employee.upload-employee');
    }
    public function uploadEmployeeDataExcel(Request $request)
    {
        if($request->hasFile('import_file')){
            \Config::set('excel.import.startRow', 13);
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                $sheet = $reader->getSheetByName('payrollworks'); // sheet with name data, but you can also use sheet indexes.
//                dd($sheet->getCell('H3')->getValue());
                foreach ($reader->toArray() as $key => $row) {
                    $data['employee_id'] = $row['employee_id'];
                    $data['employee_status'] = '1';
                    $data['employee_Fname'] = $row['first_name'];
                    $data['employee_Lname'] = $row['last_name'];
                    $data['employee_Mname'] = $row['middle_name'];
                    $data['date_hired'] = "";
                    $data['birth_day'] = "";
                    $data['gender']="";
                    $data['position']="";
                    $data['basic_pay'] = $row['basic_rate'];
                    $data['cola'] = $row['cola'];
                    $data['other_nt_pay'] = $row['allowance'];
                    $data['payroll_type'] = '1';
                    $data['pagibig_amount'] = '100';
                    $data['department'] = strtoupper($sheet->getCell('F1')->getValue());
                    $data['pag_ibig_contribution'] ='1';
                    $data['phic_status'] ='1';
                    $data['sss_status'] ='1';
                    $data['tax_status'] ='1';
                    if(!empty($data)) {
                        DB::table('employees')->insert($data);
                    }
//                $newEmployee= Employee::updateOrCreate(
//                        ['employee_id' => $row['employee_id']],
//                        ['employee_status' => '1']
//                        ['employee_Fname' => '1'],
//                        ['employee_Lname' => $row['last_name']],
//                        ['employee_Mname' => $row['middle_name']],
//                        ['date_hired' => ""],
//                        ['birth_day' => ""],
//                        ['gender' => ""],
//                        ['position' => ""],
//                        ['department' => strtoupper($sheet->getCell('F1')->getValue())],
//                        ['basic_pay' => $row['basic_rate']],
//                        ['cola' => $row['cola']],
//                        ['other_nt_pay' => $row['allowance']],
//                        ['payroll_type' => '1'],
//                        ['pagibig_amount' => '100'],
//                        ['pag_ibig_contribution' => '1'],
//                        ['phic_status' => '1'],
//                        ['sss_status' => '1'],
//                        ['tax_status' => '1']
//                    );
//                    $newEmployee->save();
                }

            });
        }
        \Illuminate\Support\Facades\Session::put('success', 'Employee table updated!!');

        return back();
    }
    public function otherComputation(Request $request)
    {
        return view('employee.otherComputation');
    }
    public function computeOther(Request $request)
    {
        dd($request);
    }

    /**
     * Batch import employees from a CSV file.
     * For each employee with an email, automatically creates a User account
     * with password "testPass" (same logic as addEmployee).
     *
     * Expected CSV columns (header row required):
     * employee_id, last_name, first_name, middle_name, gender, status,
     * date_hired, birth_date, department, position, address, email,
     * sss_number, tin_number, hdmf_number, philhealth_number, ucpb_number,
     * basic_pay, cola, other_nt_pay
     */
    public function batchImportCsv(Request $request)
    {
        // 1. Safe validation for all Laravel 5 versions
        $this->validate($request, [
            'import_file' => 'required|file|max:5120',
        ]);

        // 2. Ensure the file actually uploaded successfully before manipulating it
        if (!$request->hasFile('import_file') || !$request->file('import_file')->isValid()) {
            return response()->json(['message' => 'File upload failed or file is invalid.'], 400);
        }

        $file    = $request->file('import_file');
        $handle  = fopen($file->getRealPath(), 'r');
        
        if (!$handle) {
            return response()->json(['message' => 'Could not open the uploaded file.'], 500);
        }

        $headers = null;
        $success = 0;
        $failed  = [];
        $rowNum  = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $rowNum++;

            // First row = headers
            if ($headers === null) {
                $headers = array_map('trim', $row);
                continue;
            }

            // Skip completely blank rows
            if (empty(array_filter($row))) {
                continue;
            }

            // 3. Prevent array_combine fatal errors if a row has extra/missing commas
            if (count($headers) !== count($row)) {
                $failed[] = [
                    'row' => $rowNum, 
                    'reason' => 'Column mismatch. Expected ' . count($headers) . ' columns, but found ' . count($row) . '.'
                ];
                continue;
            }

            $data = array_combine($headers, array_map('trim', $row));

            // Validate required fields
            if (empty($data['last_name']) || empty($data['first_name'])) {
                $failed[] = ['row' => $rowNum, 'reason' => 'Missing first or last name.'];
                continue;
            }

            DB::beginTransaction();
            try {
                $employee = Employee::create([
                    'employee_id'       => $data['employee_id']      ?? null,
                    'employee_status'   => '1',
                    'employee_Lname'    => $data['last_name'],
                    'employee_Fname'    => $data['first_name'],
                    'employee_Mname'    => $data['middle_name']      ?? null,
                    'gender'            => $data['gender']           ?? null,
                    'status'            => $data['status']           ?? null,
                    'date_hired'        => !empty($data['date_hired']) ? $data['date_hired'] : null,
                    'birth_day'         => !empty($data['birth_date']) ? $data['birth_date'] : null,
                    'department'        => $data['department']       ?? null,
                    'position'          => $data['position']         ?? null,
                    'address'           => $data['address']          ?? null,
                    'email'             => !empty($data['email'])    ? $data['email']        : null,
                    'sss_number'        => $data['sss_number']       ?? null,
                    'tin_number'        => $data['tin_number']       ?? null,
                    'hdmf_number'       => $data['hdmf_number']      ?? null,
                    'philhealth_number' => $data['philhealth_number'] ?? null,
                    'ucpb_number'       => $data['ucpb_number']      ?? null,
                    'basic_pay'         => $data['basic_pay']        ?? 0,
                    'cola'              => $data['cola']             ?? 0,
                    'other_nt_pay'      => $data['other_nt_pay']     ?? 0,
                    'payroll_type'      => '1',
                    'pagibig_amount'    => '100',
                    'pag_ibig_contribution' => '1',
                    'phic_status'       => '1',
                    'sss_status'        => '1',
                    'tax_status'        => '1',
                ]);

                // Auto-create user account if email is provided
                if (!empty($data['email'])) {
                    \SGpayroll\User::firstOrCreate(
                        ['email' => $data['email']],
                        [
                            'name'        => trim($data['first_name'] . ' ' . $data['last_name']), // Safer fallback if accessor fails
                            'password'    => bcrypt('testPass'),
                            'user_type'   => 2,
                            'employee_id' => $employee->id,
                        ]
                    );
                }

                DB::commit();
                $success++;
            } catch (\Throwable $e) { // Catch \Throwable to trap fatal PHP 7+ errors as well as Exceptions
                DB::rollBack();
                $failed[] = [
                    'row'    => $rowNum,
                    'reason' => $e->getMessage(),
                ];
            }
        }

        fclose($handle);

        return response()->json([
            'success' => $success,
            'failed'  => $failed,
            'message' => "{$success} employee(s) imported successfully."
                . (count($failed) ? ' ' . count($failed) . ' row(s) failed.' : ''),
        ]);
    }


}
