<?php

namespace SGpayroll\Http\Controllers\Employee;

use Excel;
use mysql_xdevapi\Session;
use SGpayroll\Department;
use SGpayroll\Employee;
use Illuminate\Http\Request;
use SGpayroll\Employee_Loan;
use SGpayroll\Http\Controllers\Controller;
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
        $department = Department::orderBy('department_name','ASC')->get();
        $employee = Employee::orderBy('employee_Lname','ASC')->where('employee_status',"1")->get();
        $data = [
            'department' => $department,
            'employee' => $employee,
        ];
        return view('employee.index')->with($data);
    }
    public function addEmployee(Request $request)
    {
//        dd($request);
        Employee::create(
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
                'sss_number'=> $request['sss'],
                'tin_number' => $request['tin'],
                'hdmf_number' => $request['hdmf'],
                'philhealth_number' => $request['philhealth'],
                'ucpb_number' => $request['ucpb'],
                'passport_number' => $request['passport'],
                'passport_exp' => $request['passport_exp'],
            ]
        );
    }
    public function accountEmployee($id)
    {
        $department = Department::orderBy('department_name','ASC')->get();
        $employee = Employee::find($id);
        $data = [
            'department' => $department,
            "employee" => $employee,
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
        Employee::find($request['employee_id'])->update([
            "basic_pay" => $request['basic_pay'],
            "other_nt_pay" => $request['other_nt_pay'],
            "cola" => $request['cola'],
            "payroll_type" => $request['payroll_type'],
            "leave" => $request['leave'],
            "sick_leave" => $request['sick']
        ]);
        return 0;
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


}
