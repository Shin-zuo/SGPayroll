@extends('layouts.app')
@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Generate Reports</h1>
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden max-w-4xl">
    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-700 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-500"></i> Report Configuration
        </h2>
    </div>
    
    <div class="p-6">
        <form method="POST" action="/reports/view-report" class="space-y-6">
            {{csrf_field()}}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Select Report -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Select Report :</label>
                    <select id="report_type" name="report_type" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="Payroll">PAYROLL</option>
                        <option value="Sss">SSS</option>
                        <option value="Pag-IBIG">Pag-IBIG</option>
                        <option value="WITHOLDING TAX">WITHOLDING TAX</option>
                        <option value="PHILHEALTH">PHILHEALTH </option>
                        <option value="SSS LOANS">SSS LOANS</option>
                        <option value="Pag-IBIG LOANS">Pag-IBIG LOANS</option>
                        <option value="Pag-IBIG CALAMITY LOANS">Pag-IBIG CALAMITY LOANS</option>
                        <option value="13 MONTH">THIRTEEN MONTH</option>
                        <option value="ALPHA LIST">ALPHA LIST</option>
                        <option value="ALPHA LIST (MONTHLY)">ALPHA LIST (MONTHLY)</option>
                        <option value="EMPLOYEE INFORMATION">EMPLOYEE INFORMATION</option>
                    </select>
                </div>
                
                <!-- Select Department -->
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Select Department :</label>
                    <select name="department" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        @foreach($department as $departments)
                        <option value="{{$departments}}">{{strtoupper($departments)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Month Selection -->
                <div id="month">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Month :</label>
                    <input type="month" name="monthRep" id="monthRep" value="{{date('Y-m')}}" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                <!-- Quarter Selection -->
                <div id="quarter" style="display:none">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Quarter :</label>
                    <select id="quarterYear" name="quarterYear" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="1">First Half - From Nov 26 last year to May 25 current year</option>
                        <option value="2">Second Half - From May 26 current year to Nov 25 current year</option>
                    </select>
                </div>

                <!-- Payroll Number -->
                <div id="payroll_no">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Payroll No. :</label>
                    <select id="payroll_number" name="payroll_number" class="w-full text-sm border-slate-300 rounded-md p-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                <button type="button" id="btn-import-payroll-csv" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-import"></i> Import Payroll CSV
                </button>
                <button type="submit" formtarget="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-md transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payroll CSV Import Modal -->
<div class="modal fade" id="importPayrollModal" tabindex="-1" role="dialog" aria-labelledby="importPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="importPayrollModalLabel">Import Payroll Records from CSV</h4>
            </div>
            <div class="modal-body">
                <!-- Step 1: Format Guide -->
                <div id="payroll-step-1">
                    <p class="mb-4 text-slate-600">The CSV columns must match the headers listed below. This file contains 59 columns representing all indicators, calculations, and deductions necessary to compile correct payroll reports.</p>
                    
                    <div style="max-height: 250px; overflow-y: auto;" class="border rounded mb-4">
                        <table class="table table-bordered table-striped text-xs mb-0">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th>Header / Column Name</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><strong>employee_code</strong></td><td>Integer</td><td><span class="text-red-600">Yes</span></td><td>ID of employee from DB</td></tr>
                                <tr><td><strong>department</strong></td><td>String</td><td>No</td><td>Department Name</td></tr>
                                <tr><td><strong>payroll_number</strong></td><td>Integer</td><td>No</td><td>1 - 5</td></tr>
                                <tr><td><strong>monthly_record</strong></td><td>Integer</td><td><span class="text-red-600">Yes</span></td><td>Month index (1 - 12)</td></tr>
                                <tr><td><strong>year</strong></td><td>Integer</td><td><span class="text-red-600">Yes</span></td><td>Payroll Year (e.g. 2026)</td></tr>
                                <tr><td><strong>date_from</strong></td><td>Date</td><td>No</td><td>YYYY-MM-DD</td></tr>
                                <tr><td><strong>date_to</strong></td><td>Date</td><td>No</td><td>YYYY-MM-DD</td></tr>
                                <tr><td colspan="4" class="font-bold bg-slate-100 text-slate-800 text-center">Earnings & Attendance (Numeric / Decimals)</td></tr>
                                <tr><td><strong>work_days</strong></td><td>Numeric</td><td>No</td><td>Days worked</td></tr>
                                <tr><td><strong>work_days_amount</strong></td><td>Numeric</td><td>No</td><td>Total base pay earned</td></tr>
                                <tr><td><strong>overtime</strong></td><td>Numeric</td><td>No</td><td>OT Hours</td></tr>
                                <tr><td><strong>overtime_amount</strong></td><td>Numeric</td><td>No</td><td>OT Pay</td></tr>
                                <tr><td><strong>ext_reg_hrs</strong></td><td>Numeric</td><td>No</td><td>Extended Regular Hours</td></tr>
                                <tr><td><strong>ext_reg_hrs_ammount</strong></td><td>Numeric</td><td>No</td><td>Extended Regular Amount</td></tr>
                                <tr><td><strong>night_diff</strong></td><td>Numeric</td><td>No</td><td>Night differential hours</td></tr>
                                <tr><td><strong>night_diff_amount</strong></td><td>Numeric</td><td>No</td><td>Night diff amount</td></tr>
                                <tr><td><strong>night_diff_restday</strong></td><td>Numeric</td><td>No</td><td>Night diff restday hours</td></tr>
                                <tr><td><strong>night_diff_restday_amount</strong></td><td>Numeric</td><td>No</td><td>Night diff restday amount</td></tr>
                                <tr><td><strong>rest_special</strong></td><td>Numeric</td><td>No</td><td>Special holiday rest hours</td></tr>
                                <tr><td><strong>rest_special_amount</strong></td><td>Numeric</td><td>No</td><td>Special holiday rest amount</td></tr>
                                <tr><td><strong>regular_holiday</strong></td><td>Numeric</td><td>No</td><td>Regular holiday hours</td></tr>
                                <tr><td><strong>regular_holiday_amount</strong></td><td>Numeric</td><td>No</td><td>Regular holiday amount</td></tr>
                                <tr><td><strong>regular_holiday_day</strong></td><td>Numeric</td><td>No</td><td>Regular holiday day count</td></tr>
                                <tr><td><strong>regular_holiday_day_amount</strong></td><td>Numeric</td><td>No</td><td>Regular holiday day amount</td></tr>
                                <tr><td><strong>regular_holiday_day_minimum</strong></td><td>Numeric</td><td>No</td><td>Regular holiday day minimum</td></tr>
                                <tr><td><strong>regular_holiday_day_minimum_amount</strong></td><td>Numeric</td><td>No</td><td>Regular holiday day min amount</td></tr>
                                <tr><td><strong>special_holiday_day</strong></td><td>Numeric</td><td>No</td><td>Special holiday day count</td></tr>
                                <tr><td><strong>special_holiday_day_amount</strong></td><td>Numeric</td><td>No</td><td>Special holiday day amount</td></tr>
                                <tr><td><strong>special_holiday_day_minimum</strong></td><td>Numeric</td><td>No</td><td>Special holiday day minimum</td></tr>
                                <tr><td><strong>special_holiday_day_minimum_amount</strong></td><td>Numeric</td><td>No</td><td>Special holiday day min amount</td></tr>
                                <tr><td><strong>absent</strong></td><td>Numeric</td><td>No</td><td>Days absent</td></tr>
                                <tr><td><strong>absent_amount</strong></td><td>Numeric</td><td>No</td><td>Deduction for absences</td></tr>
                                <tr><td><strong>late</strong></td><td>Numeric</td><td>No</td><td>Hours late</td></tr>
                                <tr><td><strong>late_amount</strong></td><td>Numeric</td><td>No</td><td>Deduction for lates</td></tr>
                                <tr><td><strong>sick_leave</strong></td><td>Numeric</td><td>No</td><td>Sick leave days used</td></tr>
                                <tr><td><strong>sick_leave_amount</strong></td><td>Numeric</td><td>No</td><td>Sick leave amount paid</td></tr>
                                <tr><td><strong>vacation_leave</strong></td><td>Numeric</td><td>No</td><td>VL days used</td></tr>
                                <tr><td><strong>vacation_leave_amount</strong></td><td>Numeric</td><td>No</td><td>VL amount paid</td></tr>
                                <tr><td><strong>service_leave</strong></td><td>Numeric</td><td>No</td><td>Service leave days used</td></tr>
                                <tr><td><strong>service_leave_amount</strong></td><td>Numeric</td><td>No</td><td>Service leave amount paid</td></tr>
                                <tr><td><strong>total_basic_pay</strong></td><td>Numeric</td><td>No</td><td>Basic pay subtotal</td></tr>
                                <tr><td><strong>cola</strong></td><td>Numeric</td><td>No</td><td>COLA count/hours</td></tr>
                                <tr><td><strong>cola_amount</strong></td><td>Numeric</td><td>No</td><td>COLA amount</td></tr>
                                <tr><td><strong>thirteen_month</strong></td><td>Numeric</td><td>No</td><td>Thirteen month pay amount</td></tr>
                                <tr><td><strong>non_tax_other</strong></td><td>Numeric</td><td>No</td><td>Non taxable allowances</td></tr>
                                <tr><td><strong>total_other_pay</strong></td><td>Numeric</td><td>No</td><td>Other earnings subtotal</td></tr>
                                <tr><td><strong>gross_pay</strong></td><td>Numeric</td><td>No</td><td>Total gross earnings</td></tr>
                                <tr><td colspan="4" class="font-bold bg-slate-100 text-slate-800 text-center">Tax & Contributions Deductions</td></tr>
                                <tr><td><strong>witholding_tax</strong></td><td>Numeric</td><td>No</td><td>Withholding Tax amount</td></tr>
                                <tr><td><strong>sss_contribution</strong></td><td>Numeric</td><td>No</td><td>SSS Employee contribution</td></tr>
                                <tr><td><strong>phic_contribution</strong></td><td>Numeric</td><td>No</td><td>PhilHealth contribution</td></tr>
                                <tr><td><strong>hdmf_contribution</strong></td><td>Numeric</td><td>No</td><td>Pag-IBIG contribution</td></tr>
                                <tr><td><strong>provident_fund</strong></td><td>Numeric</td><td>No</td><td>SSS Provident Fund contribution</td></tr>
                                <tr><td><strong>sss_loan</strong></td><td>Numeric</td><td>No</td><td>SSS regular loan deduction</td></tr>
                                <tr><td><strong>sss_calamity_loan</strong></td><td>Numeric</td><td>No</td><td>SSS calamity loan deduction</td></tr>
                                <tr><td><strong>hdmf_loan</strong></td><td>Numeric</td><td>No</td><td>Pag-IBIG regular loan deduction</td></tr>
                                <tr><td><strong>hdmf_calamity_loan</strong></td><td>Numeric</td><td>No</td><td>Pag-IBIG calamity loan deduction</td></tr>
                                <tr><td><strong>company_loan</strong></td><td>Numeric</td><td>No</td><td>Company loan deduction</td></tr>
                                <tr><td><strong>other_loan</strong></td><td>Numeric</td><td>No</td><td>Other loan deduction</td></tr>
                                <tr><td><strong>total_deduction</strong></td><td>Numeric</td><td>No</td><td>Total deductions subtotal</td></tr>
                                <tr><td><strong>net_pay</strong></td><td>Numeric</td><td>No</td><td>Net pay (Take home)</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="button" id="btn-proceed-payroll-upload" class="btn btn-primary">Proceed to Upload</button>
                    </div>
                </div>

                <!-- Step 2: Upload File Input -->
                <div id="payroll-step-2" style="display: none;">
                    <form id="payrollImportForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="import_file" class="control-label">Select CSV File :</label>
                            <input type="file" id="payroll_import_file" name="import_file" class="form-control" accept=".csv,text/csv,text/plain" required>
                        </div>
                        <div id="payroll-import-results" style="display:none;" class="alert mb-4"></div>
                        <div class="text-center mt-4">
                            <button type="button" id="btn-back-payroll-step-1" class="btn btn-secondary mr-2">Back</button>
                            <button type="submit" id="btn-submit-payroll-import" class="btn btn-success">Import Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/report/report.js"></script>
<script>
    $(document).ready(function() {
        $('#btn-import-payroll-csv').on('click', function() {
            $('#payroll-step-1').show();
            $('#payroll-step-2').hide();
            $('#payroll_import_file').val('');
            $('#payroll-import-results').hide().empty();
            $('#importPayrollModal').modal('show');
        });

        $('#btn-proceed-payroll-upload').on('click', function() {
            $('#payroll-step-1').hide();
            $('#payroll-step-2').show();
        });

        $('#btn-back-payroll-step-1').on('click', function() {
            $('#payroll-step-2').hide();
            $('#payroll-step-1').show();
        });

        $('#payrollImportForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#btn-submit-payroll-import').prop('disabled', true).text('Importing...');
            $('#payroll-import-results').hide().removeClass('alert-success alert-danger alert-warning').empty();

            $.ajax({
                url: '/reports/batch-import',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#btn-submit-payroll-import').prop('disabled', false).text('Import Now');
                    
                    var alertClass = 'alert-success';
                    var html = '<strong>' + response.message + '</strong>';

                    if (response.failed && response.failed.length > 0) {
                        alertClass = 'alert-warning';
                        html += '<hr><p class="mb-1 font-bold">Failed rows:</p><ul class="pl-4 mb-0 text-xs">';
                        response.failed.forEach(function(item) {
                            html += '<li>Row ' + item.row + ': ' + item.reason + '</li>';
                        });
                        html += '</ul>';
                    }

                    $('#payroll-import-results').addClass(alertClass).html(html).show();
                    
                    if (response.success > 0) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2500);
                    }
                },
                error: function(xhr) {
                    $('#btn-submit-payroll-import').prop('disabled', false).text('Import Now');
                    var errorMsg = 'An error occurred during import.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#payroll-import-results').addClass('alert-danger').html('<strong>' + errorMsg + '</strong>').show();
                }
            });
        });
    });
</script>