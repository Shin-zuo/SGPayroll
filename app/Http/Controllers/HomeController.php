<?php

namespace SGpayroll\Http\Controllers;

use SGpayroll\Department;
use SGpayroll\Employee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::orderBy('department_name','ASC')->get();
        $employee = Employee::orderBy('employee_Lname','ASC')->get();
        $data = [
            'department' => $department,
            'employee' => $employee,
        ];
        return view('employee.index')->with($data);
    }
}
