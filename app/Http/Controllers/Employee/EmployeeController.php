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
        if (empty($request['employee_id'])) {
            return response()->json(['success' => false, 'message' => 'Employee ID is required.'], 422);
        }
        if (empty($request['employee_Lname']) || empty($request['employee_Fname'])) {
            return response()->json(['success' => false, 'message' => 'First and Last name are required.'], 422);
        }
        if (empty($request['emp_email'])) {
            return response()->json(['success' => false, 'message' => 'Login Email Address is required.'], 422);
        }
        if (empty($request['contact_no'])) {
            return response()->json(['success' => false, 'message' => 'Contact Number is required.'], 422);
        }

        // Check for duplicate employee ID
        if (Employee::where('employee_id', $request['employee_id'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Employee ID "' . $request['employee_id'] . '" is already assigned to another employee.'], 422);
        }

        try {
            $employee = Employee::create(
                [
                    'employee_id' => $request['employee_id'],
                    'employee_status' => "1",
                    'employee_Fname' => $request['employee_Fname'],
                    'employee_Lname' => $request['employee_Lname'],
                    'employee_Mname' => !empty($request['employee_Mname']) ? $request['employee_Mname'] : null,
                    'date_hired' => $request['date_hired'],
                    'birth_day' => $request['birth_date'],
                    'gender' => $request['gender'],
                    'department' => $request['department'],
                    'position' => $request['sub_department'],
                    'status' => $request['status'],
                    'address' => $request['address'],
                    'contactNo' => $request['contact_no'],
                    'email' => $request['emp_email'],
                    'sss_number'=> $request['sss'],
                    'tin_number' => $request['tin'],
                    'hdmf_number' => $request['hdmf'],
                    'philhealth_number' => $request['philhealth'],
                    'ucpb_number' => $request['ucpb'],
                    'passport_number' => null,
                    'passport_exp' => null,
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

            return response()->json([
                'success' => true,
                'message' => 'Employee added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add employee: ' . $e->getMessage()
            ], 500);
        }
    }

    public function accountEmployee($id)
    {
        $department    = Department::orderBy('department_name', 'ASC')->get();
        $employee      = Employee::findOrFail($id);
        $currentYear   = Carbon::now()->year;
        $leaveWindowOpen = LeaveWindowSetting::isOpen();

        $vacationLedger = DB::table('leave_credit_ledgers')
            ->where('employee_id', $id)
            ->where('leave_type', 'vacation')
            ->where('year', $currentYear)
            ->first();

        $sickLedger = DB::table('leave_credit_ledgers')
            ->where('employee_id', $id)
            ->where('leave_type', 'sick')
            ->where('year', $currentYear)
            ->first();

        // 2nd week of December reload check (Dec 14+)
        $isDecemberWindow = (Carbon::now()->month === 12 && Carbon::now()->day >= 14);
        if ($isDecemberWindow && (!$vacationLedger || !$sickLedger)) {
            LeaveCreditLedger::reloadAnnualCredits($currentYear);
            $vacationLedger = DB::table('leave_credit_ledgers')->where('employee_id', $id)->where('leave_type', 'vacation')->where('year', $currentYear)->first();
            $sickLedger = DB::table('leave_credit_ledgers')->where('employee_id', $id)->where('leave_type', 'sick')->where('year', $currentYear)->first();
        }

        $vacationBalance = $vacationLedger ? max(0, $vacationLedger->credit_limit - $vacationLedger->used_days) : ($employee->leave ?: 6);
        $sickBalance     = $sickLedger     ? max(0, $sickLedger->credit_limit - $sickLedger->used_days)         : ($employee->sick_leave ?: 5);

        $data = [
            'department'       => $department,
            'employee'         => $employee,
            'leaveWindowOpen'  => $leaveWindowOpen,
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
           'employee_Mname' => !empty($request['employee_Mname']) ? $request['employee_Mname'] : null,
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
           'passport_number' => null,
           'salary_status' => $request['salary_status'],
           'passport_exp' => null,
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
        $employeeId = $request['employee_id'];
        $employee = Employee::findOrFail($employeeId);

        $updateData = [
            'basic_pay'    => $request['basic_pay'],
            'other_nt_pay' => $request['other_nt_pay'],
            'cola'         => $request['cola'],
            'payroll_type' => $request['payroll_type'],
        ];

        $leaveUpdated = false;

        // Vacation Leave
        if ($request->has('leave') && $request['leave'] !== null && $request['leave'] !== '') {
            $vacationDays = floatval($request['leave']);
            $updateData['leave'] = $vacationDays;

            $vLedger = DB::table('leave_credit_ledgers')
                ->where('employee_id', $employeeId)
                ->where('leave_type', 'vacation')
                ->where('year', $year)
                ->first();

            if ($vLedger) {
                DB::table('leave_credit_ledgers')
                    ->where('id', $vLedger->id)
                    ->update([
                        'credit_limit' => $vacationDays,
                        'updated_at'   => Carbon::now()
                    ]);
            } else {
                DB::table('leave_credit_ledgers')->insert([
                    'employee_id'  => $employeeId,
                    'leave_type'   => 'vacation',
                    'year'         => $year,
                    'credit_limit' => $vacationDays,
                    'used_days'    => 0,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now()
                ]);
            }
            $leaveUpdated = true;
        }

        // Sick Leave
        if ($request->has('sick') && $request['sick'] !== null && $request['sick'] !== '') {
            $sickDays = floatval($request['sick']);
            $updateData['sick_leave'] = $sickDays;

            $sLedger = DB::table('leave_credit_ledgers')
                ->where('employee_id', $employeeId)
                ->where('leave_type', 'sick')
                ->where('year', $year)
                ->first();

            if ($sLedger) {
                DB::table('leave_credit_ledgers')
                    ->where('id', $sLedger->id)
                    ->update([
                        'credit_limit' => $sickDays,
                        'updated_at'   => Carbon::now()
                    ]);
            } else {
                DB::table('leave_credit_ledgers')->insert([
                    'employee_id'  => $employeeId,
                    'leave_type'   => 'sick',
                    'year'         => $year,
                    'credit_limit' => $sickDays,
                    'used_days'    => 0,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now()
                ]);
            }
            $leaveUpdated = true;
        }

        $employee->update($updateData);

        return response()->json([
            'success' => true, 
            'message' => $leaveUpdated ? 'Salary and leave credits updated successfully!' : 'Salary rates updated successfully!'
        ]);
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
     * Download the pre-formatted Excel (.xlsx) template for bulk employee onboarding.
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/employee_import_template.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath, 'employee_import_template.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }
        return redirect()->back()->with('error', 'Employee import template file not found.');
    }

    /**
     * Batch import employees from a CSV file.
     * Automatically creates both the Employee record and their User Portal account
     * with default password "testPass".
     *
     * Required CSV columns (header row required):
     * employee_id, last_name, first_name, gender, date_hired, birth_date,
     * department, position, contact_no, email
     *
     * Optional CSV columns:
     * middle_name, status, address, sss_number, tin_number, hdmf_number,
     * philhealth_number, ucpb_number, basic_pay, cola, other_nt_pay
     */
    public function batchImportCsv(Request $request)
    {
        // 1. Safe validation for Laravel
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
                // Remove UTF-8 BOM if present on first header
                $row[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row[0]);
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
                    'reason' => 'Column count mismatch. Expected ' . count($headers) . ' columns, but row has ' . count($row) . '.'
                ];
                continue;
            }

            $data = array_combine($headers, array_map('trim', $row));

            // 4. Validate Required Fields
            $missingFields = [];
            if (empty($data['employee_id'])) $missingFields[] = 'employee_id';
            if (empty($data['last_name']))   $missingFields[] = 'last_name';
            if (empty($data['first_name']))  $missingFields[] = 'first_name';
            if (empty($data['gender']))      $missingFields[] = 'gender';
            if (empty($data['date_hired']))  $missingFields[] = 'date_hired';
            if (empty($data['birth_date']))  $missingFields[] = 'birth_date';
            if (empty($data['department']))  $missingFields[] = 'department';
            if (empty($data['position']))    $missingFields[] = 'position';

            $contactVal = !empty($data['contact_no']) ? $data['contact_no'] : (!empty($data['contact_number']) ? $data['contact_number'] : null);
            if (empty($contactVal)) {
                $missingFields[] = 'contact_no';
            }

            if (empty($data['email'])) {
                $missingFields[] = 'email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $failed[] = ['row' => $rowNum, 'reason' => 'Invalid email address format: "' . $data['email'] . '".'];
                continue;
            }

            if (!empty($missingFields)) {
                $failed[] = ['row' => $rowNum, 'reason' => 'Missing required field(s): ' . implode(', ', $missingFields) . '.'];
                continue;
            }

            // 5. Check Duplicates (Employee ID & Email)
            if (Employee::where('employee_id', $data['employee_id'])->exists()) {
                $failed[] = ['row' => $rowNum, 'reason' => 'Employee ID "' . $data['employee_id'] . '" is already registered in the system.'];
                continue;
            }

            if (\SGpayroll\User::where('email', $data['email'])->exists()) {
                $failed[] = ['row' => $rowNum, 'reason' => 'Email address "' . $data['email'] . '" is already registered to an existing user account.'];
                continue;
            }

            DB::beginTransaction();
            try {
                $employee = Employee::create([
                    'employee_id'       => $data['employee_id'],
                    'employee_status'   => '1',
                    'employee_Lname'    => $data['last_name'],
                    'employee_Fname'    => $data['first_name'],
                    'employee_Mname'    => !empty($data['middle_name']) ? $data['middle_name'] : null,
                    'gender'            => $data['gender'],
                    'status'            => !empty($data['status']) ? $data['status'] : null,
                    'date_hired'        => $data['date_hired'],
                    'birth_day'         => $data['birth_date'],
                    'department'        => $data['department'],
                    'position'          => $data['position'],
                    'address'           => !empty($data['address']) ? $data['address'] : null,
                    'contactNo'         => $contactVal,
                    'email'             => $data['email'],
                    'sss_number'        => !empty($data['sss_number']) ? $data['sss_number'] : null,
                    'tin_number'        => !empty($data['tin_number']) ? $data['tin_number'] : null,
                    'hdmf_number'       => !empty($data['hdmf_number']) ? $data['hdmf_number'] : null,
                    'philhealth_number' => !empty($data['philhealth_number']) ? $data['philhealth_number'] : null,
                    'ucpb_number'       => !empty($data['ucpb_number']) ? $data['ucpb_number'] : (!empty($data['ub_number']) ? $data['ub_number'] : null),
                    'basic_pay'         => is_numeric($data['basic_pay'] ?? '') ? $data['basic_pay'] : 0,
                    'cola'              => is_numeric($data['cola'] ?? '') ? $data['cola'] : 0,
                    'other_nt_pay'      => is_numeric($data['other_nt_pay'] ?? '') ? $data['other_nt_pay'] : 0,
                    'payroll_type'      => '1',
                    'pagibig_amount'    => '100',
                    'pag_ibig_contribution' => '1',
                    'phic_status'       => '1',
                    'sss_status'        => '1',
                    'tax_status'        => '1',
                ]);

                // Create User Portal Account
                \SGpayroll\User::create([
                    'name'        => trim($data['first_name'] . ' ' . $data['last_name']),
                    'email'       => trim($data['email']),
                    'password'    => bcrypt('testPass'),
                    'user_type'   => 2,
                    'employee_id' => $employee->id,
                ]);

                DB::commit();
                $success++;
            } catch (\Throwable $e) {
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
            'message' => "{$success} employee(s) and portal account(s) imported successfully."
                . (count($failed) ? ' ' . count($failed) . ' row(s) failed.' : ''),
        ]);
    }



}
