<?php

namespace SGpayroll\Http\Controllers\Salary;

use Illuminate\Http\Request;
use SGpayroll\Employee;
use SGpayroll\Http\Controllers\Controller;

class SalaryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $employee_salary = Employee::orderBy('employee_Lname','ASC')->get();
        $data = [
            "employee_salary" => $employee_salary,
        ];
        return view('salary.index')->with($data);
    }
}
