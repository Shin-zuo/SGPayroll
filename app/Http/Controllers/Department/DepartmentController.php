<?php

namespace SGpayroll\Http\Controllers\Department;

use SGpayroll\Department;
use Illuminate\Http\Request;
use SGpayroll\Employee;
use SGpayroll\Employee_Payrolls;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\Payroll_Timesheet;
use SGpayroll\Sub_Department;
use SGpayroll\Timesheet;
use SGpayroll\Timesheet_Computation;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
//        dd(Employee_Payrolls::all()->pluck('department')->unique());
//        $file = file(storage_path('AGL_001.TXT'));
//        $file_delete_first_line = array_slice($file, 1, count($file));
//
//        foreach($file_delete_first_line as $lines) {
//        $keywords = preg_split("/[\t, ]+/", $lines);
////        dd($keywords);
//            Payroll_Timesheet::create([
//                'employee_code' => $keywords[2],
//                'time_in' => $keywords[8],
//                'time_out' => $keywords[8],
//                'date_log' => $keywords[7],
//            ]);
//        }
//
//        $time =DB::table('payroll_timesheet')->select(DB::raw('max(time_in) as time_out,min(time_in) as time_in,max(employee_code) as employee_code,max(date_log) as date_log'))->groupBy('date_log','employee_code')->get();
//        foreach ($time as $times)
//        {
//                $dura = (Carbon::parse($times->time_out)->diffInSeconds(Carbon::parse($times->time_in)));
//                Timesheet_Computation::create([
//                    "employee_code" => $times->employee_code,
//                    "date_log" => $times->date_log,
//                    "time_in" => $times->time_in,
//                    "time_out" => $times->time_out,
//                    "duration" => gmdate('H:i', $dura),
//                ]);
//        }

        $department = Department::orderBy('department_name','ASC')->get();
        $data = [
            'department' => $department,
        ];
        return view('department.index')->with($data);
    }
    public function updatePeriod(Request $request)
    {
        Department::find($request['id'])->update([
            'date_from' => $request['date_from'],
            'date_to' => $request['date_to']
        ]);
    }
    public function edit($id)
    {
//        dd($id);
        $department = Department::find($id);
        $sub_department =  Department::find($id)->sub_department()->get();
        $data = [
            'department' => $department,
            'sub_department' => $sub_department,
        ];
       return view('department.edit')->with($data);
    }
    public function addGroup(Request $request)
    {
//        dd($request);
        if ($request['group_name'] == null)
        {
        }
        else
            {
            Department::create(
                [
                    'employer_tin' => $request['employer_tin'],
                    'employer_sss' => $request['employer_sss'],
                    'department_code' => strtoupper($request['group_code']),
                    'department_name' => strtoupper($request['group_name']),
                    'tel_no' => $request['employer_no'],
                    'department_address' => strtoupper($request['group_address']),
                    'zip_code' => $request['zip'],
                    'payroll_type'=> $request['payroll_type'],
                    'generated_code' => str_random(7),
                ]
            );
        }
    }
    public function addSubGroup(Request $request)
    {
        if ($request['sub_group_name']==null)
        {

        }
        else
        {
            Sub_Department::create(
                [
                    'sub_department_name' => strtoupper($request['sub_group_name']),
                    'department_code' => $request['generated_code'],
                ]
            );
        }

    }
    public function updateGroupName(Request $request)
    {

        Department::find($request['id'])->update([
           'department_name' => strtoupper($request['name']),
            'department_code' => strtoupper($request['code']),
            'employer_tin' => $request['tin'],
            'employer_sss' => $request['sss'],
            'tel_no' => $request['telno'],
            'department_address' => strtoupper($request['address']),
            'zip_code' => $request['zip'],
            'payroll_type' => $request['payroll_type'],
            'date_from' => $request['month13From'],
            'date_to' => $request['month13To']
        ]);
        Employee::where('department',$request['old_code'])->update([
            'department' => strtoupper($request['code'])
        ]);
        return 0;
    }

}
