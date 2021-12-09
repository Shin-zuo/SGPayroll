<?php

namespace SGpayroll\Http\Controllers;

use Illuminate\Http\Request;
use SGpayroll\Department;
use SGpayroll\Employee;
use SGpayroll\Employee_Payrolls;

class EditController extends Controller
{
    public function index()
    {
        $department = Department::all();;
    	return view('edit.index',compact('department'));
    }
    public function getDepartmentData(Request $request)
    {
        $employee = Employee::where("department","=",$request['group_code'])->orderBy('employee_Lname','ASC')->get();
        return $employee;
    }
    public function getPreviousData(Request $request)
    {
//        dd($request);
        $employeeData = Employee_Payrolls::where('employee_code',$request['employee_code'])->orderBy('created_at','DESC')->first();
        return $employeeData;
    }
}
