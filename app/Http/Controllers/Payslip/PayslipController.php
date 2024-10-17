<?php

namespace SGpayroll\Http\Controllers\Payslip;

use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use SGpayroll\Department;
use SGpayroll\Employee;
use SGpayroll\Employee_Payrolls;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Payroll_Employee;

class PayslipController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $department = Department::orderBy('department_name','ASC')->get();
//        $employee_payroll = Employee_Payrolls::find(2);
//        dd($employee_payroll->department()->get());
        return view('payslip.index',compact('department'));
    }
    public function viewPayslip(Request $request)
    {
       $this->validate($request,[
           'department' => 'required'
       ]);
//       dd($request);
        $department = Department::orderBy('department_name','DESC')->get();
        if($request->has('department') && $request->has('employee_id'))
        {
            $payslip = Employee_Payrolls::whereYear('date_to', Carbon::parse($request['date_payslip'])->year)
                ->where('monthly_record', Carbon::parse($request['date_payslip'])->month)
                ->where('department','=',$request['department'])
                ->where('employee_code','=',$request['employee_id'])
                ->where('payroll_number','=',$request['payroll_number'])
                ->get();
        }
        if($request->has('department') && $request->has('print_all'))
        {

            $payslip = Employee_Payrolls::whereYear('date_to', Carbon::parse($request['date_payslip'])->year)
                ->where('monthly_record', Carbon::parse($request['date_payslip'])->month)
                ->where('department','=',$request['department'])
                ->where('payroll_number','=',$request['payroll_number'])
                ->get();
//            dd($payslip);
        }
        $data = [
            'department' => $department,
            'payslip' => $payslip
        ];
        $pdf = PDF::loadView('payslip.print', $data);
        return $pdf->stream('payslip.pdf');
        return view('payslip.print');
    }
    public function showDataPayslip(Request $request)
    {
//        dd($request);
        $sub_group = Employee::where("department","=",$request['group_id'])->orderBy('employee_Lname','ASC')->get();
        return $sub_group;
    }
}
