<?php

namespace SGpayroll\Http\Controllers\Loan;

use Illuminate\Http\Request;
use SGpayroll\Department;
use SGpayroll\Employee;
use SGpayroll\Employee_Loan;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Loan;

class LoanController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function sss_loan()
    {
        $department = Department::all();
        return view('loan.sss-loan',compact('department'));
    }
    public function departmentEmployee(Request $request)
    {
        $employee = Employee::where('department','=',$request['department'])->orderBy('employee_Fname','ASC')->get();
        return $employee;
    }
    public function insertLoanData(Request $request)
    {
//        dd($request);
        $sss_loan_type ='';
        if($request['loan_type']==1)
        {
            $sss_loan_type = 'S';
        }
        if($request['loan_type']==2)
        {
            $sss_loan_type = 'C';
        }
        Employee_Loan::create([
            'employee_code' => $request['employee_id'],
            'employee_id' => $request['id'],
            'loan_type' => $request['loan_type'],
            'loan_name' => $request['loan_name'],
            'sss_loan_type' => $sss_loan_type,
            'promissory_note' => $request['promissory'],
            'loan_date' => $request['date_granted'],
            'original_term' => $request['original_term'],
            'loan_amount' => $request['amountLoan'],
            'deduction' => $request['deduction'],
            'deduction_date' => $request['deduction_date'],
            'remaining_term' => $request['remaining_term'],
            'interest' => $request['interest'],
            'balance' => $request['balance'],
            'total_laon' => $request['totalLoans'],
            'active' => $request['active']
        ]);
        return 0;

    }
    public function getLoanData(Request $request)
    {
        $loan = Employee_Loan::find($request['id']);
        return $loan;
    }
    public function updateLoanData(Request $request)
    {
        $this->validate($request,[
            'deduction_date' => 'required|date',
        ]);
        Employee_Loan::find($request['id'])->update([
            'deduction_date' => $request['deduction_date'],
            'original_term' => $request['original_term'],
            'remaining_term' => $request['remaining_term'],
            'loan_amount' => $request['amountLoan'],
            'interest' => $request['interest'],
            'total_laon' => $request['totalLoans'],
            'deduction' => $request['deduction'],
            'balance' => $request['balance'],
            'active' => $request['active']
        ]);
        return 0;
    }
    public function deleteLoanData(Request $request)
    {
        Employee_Loan::find($request['id'])->delete();
        return 0;
    }
}
