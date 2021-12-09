<?php

namespace SGpayroll\Http\Controllers\Deduction;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Loan;
use SGpayroll\Phil_Table;
use SGpayroll\Sss_Table;

class DeductionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('deduction.index');
    }
    public function sss()
    {
        $sss_table = Sss_Table::all();
        $data = [
            'sss_table' => $sss_table,
        ];
        return view('deduction.sss')->with($data);

    }
    public function philhealth()
    {
        $phil_table = Phil_Table::all();
        $data = [
            'phil_table' => $phil_table,
        ];
        return view('deduction.philhealth')->with($data);
    }
    public function pagibig()
    {
        return view('deduction.pagibig');
    }
    public function loans()
    {
        $loans_type = Loan::all();
        $data = [
            "loan" => $loans_type,
        ];
        return view('deduction.loans')->with($data);
    }
    public function addLoanType(Request $request)
    {
        Loan::create([
            "loan_type_name" => strtoupper($request['loan_type_name']),
            "loan_id" => str_random(6),
        ]);
        return 0;
    }
}
