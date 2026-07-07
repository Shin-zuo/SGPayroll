<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Employee\EmployeeController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Home
Route::get('/', 'HomeController@index')->name('home');

// Shared Auth Routes
Route::middleware(['auth'])->group(function () {
    // Admin Settings (accessible by Super Admin and HR/Admin)
    Route::get('/admin/settings', 'Admin\AdminSettingsController@index');
    Route::post('/admin/settings', 'Admin\AdminSettingsController@update');
});

// Admin & HR Portal Routes
Route::middleware(['auth', 'admin_hr'])->group(function () {
    //Employee
    Route::get('/employee','Employee\EmployeeController@index')->name('employee');
    Route::get('/employee/inactive','Employee\EmployeeController@inactiveEmployee');
    Route::get('/employee/upload-employees','Employee\EmployeeController@uploadEmployee');
    Route::get('/employee/addEmployee','Employee\EmployeeController@addEmployee');
    Route::get('/employee/UpdateEmployeeAccount','Employee\EmployeeController@updateAccount');
    Route::get('/employee/DeleteEmployeeAccount/{id?}','Employee\EmployeeController@destroy');
    Route::get('/employee/ActiveEmployeeAccount/{id?}','Employee\EmployeeController@turnActive');
    Route::get('/employee/account/{id}','Employee\EmployeeController@accountEmployee');
    Route::get('/employee/attendance/{id}','Employee\EmployeeController@attendanceEmployee');
    Route::get('/employee/requestData', 'Employee\EmployeeController@showData');
    Route::get('/account/updateSalary','Employee\EmployeeController@updateSalary');
    Route::get('/account/deductionSalary','Employee\EmployeeController@deductionEmployee');
    Route::get('/employee/account/{id}/loans','Employee\EmployeeController@loansEmployee');
    Route::get('/employee/account/{id}/loans/loansData','Employee\EmployeeController@loansEmployeeData');
    Route::get('/employee/account/{id}/other-computation','Employee\EmployeeController@otherComputation');
    Route::get('/employee/account/{id}/deductionData','Employee\EmployeeController@deductionEmployee');
    Route::get('/employee/account/{id}/other-computation/computeOther','Employee\EmployeeController@computeOther');
    Route::post('/uploadFile-employee/importEmployeeExcel', 'Employee\EmployeeController@uploadEmployeeDataExcel');
    Route::post('/employee/batch-import', 'Employee\EmployeeController@batchImportCsv');

    //Department
    Route::get('/department','Department\DepartmentController@index');
    Route::get('/payroll/{id}','Payroll\PayrollController@index');
    Route::get('/department/addGroup/addGroups','Department\DepartmentController@addGroup');
    Route::get('/department/{id}/addSubGroup','Department\DepartmentController@addSubGroup');
    Route::get('/department/update-period','Department\DepartmentController@updatePeriod');
    Route::get('/department/update-group','Department\DepartmentController@updateGroupName');
    Route::get('/department/delete-group','Department\DepartmentController@deleteGroup');
    Route::get('/department/{id}','Department\DepartmentController@edit');

    //Deduction
    Route::get('/deduction','Deduction\DeductionController@index');
    Route::get('/sss','Deduction\DeductionController@sss');
    Route::get('/philhealth','Deduction\DeductionController@philhealth');
    Route::get('/pag-ibig','Deduction\DeductionController@pagibig');
    Route::get('/loans/addLoanData', 'Deduction\DeductionController@addLoanType');

    //Payslip
    Route::get('/payslip','Payslip\PayslipController@index');
    Route::post('/payslip/view-payslip','Payslip\PayslipController@viewPayslip');
    Route::get('/payslip/requestDataPayslip', 'Payslip\PayslipController@showDataPayslip');

    //Salary
    Route::get('/salary','Salary\SalaryController@index');

    //Loan
    Route::get('/loans','Loan\LoanController@sss_loan');
    Route::get('/loans/deptEmployee','Loan\LoanController@departmentEmployee');
    Route::get('/loans/insertLoanData','Loan\LoanController@insertLoanData');
    Route::get('/loans/getLoanData','Loan\LoanController@getLoanData');
    Route::get('/loans/updateLoanData','Loan\LoanController@updateLoanData');
    Route::get('/loans/deleteLoanData','Loan\LoanController@deleteLoanData');

    //Payroll
    Route::get('/payroll','Payroll\PayrollController@index');
    Route::get('/payroll/departmentData','Payroll\PayrollController@departmentData');
    Route::get('/payroll/dataDeptEmployee','Payroll\PayrollController@dataDeptEmployee');
    Route::get('/payroll/{department}/BasicComputation','Payroll\PayrollController@BasicComputation');
    Route::get('/thirteen-month/{department}','Payroll\PayrollController@thirteenCompute');
    Route::get('/payroll/{department}/insetFinishData','Payroll\PayrollController@insertFinishData');
    Route::get('/payroll/payroll-report','Payroll\PayrollController@payrollReport');
    Route::get('/payroll/payroll-update/{id}','Payroll\PayrollController@updateData');
    Route::get('/payroll/{department}/checkPayrollNo','Payroll\PayrollController@payrollNo');

    //Reports
    Route::get('/reports','Reports\ReportsController@index');
    Route::post('/reports/view-report','Reports\ReportsController@viewReport');
    Route::post('/reports/batch-import', 'Reports\ReportsController@batchImportPayrollCsv');

    //edit
    Route::get('/edit','EditController@index');
    Route::get('/edit/requestEmployee', 'EditController@getDepartmentData');
    Route::get('/edit/requestEmployeeData', 'EditController@getPreviousData');

    //QuickPayroll
    Route::get('quick-payroll','QuickPayroll\QuickPayrollController@index');
    Route::post('quick-payroll/importExcel', 'QuickPayroll\QuickPayrollController@importExcel');

    // Leave Applications (Admin)
    Route::get('/leave-applications', 'Leave\LeaveApplicationController@index');
    Route::get('/leave-applications/approve/{id}', 'Leave\LeaveApplicationController@approve');
    Route::get('/leave-applications/reject/{id}', 'Leave\LeaveApplicationController@reject');
    Route::get('/api/leave-balance/{employee_id}/{leave_type}/{year}', 'Leave\LeaveApplicationController@checkBalance');
});

// Employee Portal Routes
Route::middleware(['auth', 'employee_portal'])->group(function () {
    Route::get('/portal', 'Portal\PortalController@index');
    Route::get('/portal/loans', 'Portal\PortalController@loans');
    Route::get('/portal/leave-balance', 'Portal\PortalController@leaveBalance');
    Route::post('/portal/leave-apply', 'Portal\PortalController@applyLeave');
    Route::get('/portal/payslips', 'Portal\PortalController@payslips');
    Route::get('/portal/payslips/{id}/download', 'Portal\PortalController@downloadPayslip');
    Route::get('/portal/contributions', 'Portal\PortalController@contributions');
    Route::get('/portal/profile', 'Portal\EmployeeProfileController@index');
    Route::post('/portal/profile', 'Portal\EmployeeProfileController@update');
});

// Super Admin — Leave Window Management
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/superadmin/leave-window', 'Admin\LeaveWindowController@index')->name('superadmin.leave-window');
    Route::post('/superadmin/leave-window/open', 'Admin\LeaveWindowController@open')->name('superadmin.leave-window.open');
    Route::post('/superadmin/leave-window/close', 'Admin\LeaveWindowController@close')->name('superadmin.leave-window.close');
    Route::post('/superadmin/leave-window/reset-lock', 'Admin\LeaveWindowController@resetEmployeeLock')->name('superadmin.leave-window.reset-lock');
});

