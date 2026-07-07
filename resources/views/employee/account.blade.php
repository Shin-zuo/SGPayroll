@extends('layouts.app')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Employee Account Settings</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Employees</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Account</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-base font-semibold text-slate-800">{{ $employee->full_name }}</h2>
            <p class="text-xs text-slate-500">Manage rates, deductions, previous information, and profile metrics</p>
        </div>
        <div class="flex items-center space-x-2">
            @if(auth()->user()->user_type == 1)
            <button type="button" id="btn-open-rates"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors"
                data-toggle="modal" data-target="#salaryModal">
                <i class="fa fa-plus mr-1.5"></i> Rates
            </button>
            @endif
            <button type="button" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors" data-toggle="modal" data-target="#deductionModal">
                <i class="fa fa-cut mr-1.5"></i> Deduction
            </button>
            <a href="/employee/account/{{$employee->id}}/loans" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors">
                <i class="fa fa-receipt mr-1.5"></i> Add Loan
            </a>
            <a href="/employee/account/{{$employee->id}}/other-computation" class="inline-flex items-center bg-slate-600 hover:bg-slate-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors">
                <i class="fa fa-history mr-1.5"></i> Previous Info
            </a>
        </div>
    </div>
    
    <div class="p-6">
        <form id="employeeAccountForm">
            <input type="hidden" name="id" id="id" value="{{$employee->id}}">
            
            <!-- Admin / Minimum Wager Status Checks -->
            <div class="flex items-center space-x-6 mb-6 pb-6 border-b border-slate-100">
                <label class="inline-flex items-center text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" id="categories" name="categories" value="1" @if($employee->categories=='true') checked @endif class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-2">
                    <span>ADMIN ROLE</span>
                </label>
                <label class="inline-flex items-center text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" id="salary_status" name="salary_status" value="1" @if($employee->salary_status=='true') checked @endif class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-2">
                    <span>MINIMUM WAGER</span>
                </label>
            </div>

            <!-- Profile Info Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">User Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="fname">First Name</label>
                        <input type="text" class="form-control w-full" id="fname" value="{{$employee->employee_Fname}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="mname">Middle Name</label>
                        <input type="text" class="form-control w-full" id="mname" value="{{$employee->employee_Mname}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="lname">Last Name</label>
                        <input type="text" class="form-control w-full" id="lname" value="{{$employee->employee_Lname}}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="gender">Gender</label>
                        <select class="form-control w-full" id="gender">
                            <option value="{{$employee->gender}}">{{$employee->gender}}</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="status">Civil Status</label>
                        <select id="status" class="form-control w-full" name="status">
                            <option value="Single" @if($employee->status == 'Single') selected @endif>Single</option>
                            <option value="Married" @if($employee->status == 'Married') selected @endif>Married</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control w-full" id="date_of_birth" value="{{$employee->birth_day}}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="email">Email Address</label>
                        <input type="email" class="form-control w-full" id="email" value="{{$employee->email}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="address">Residential Address</label>
                        <textarea class="form-control w-full" id="address" rows="2">{{$employee->address}}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 my-6">

            <!-- Case of Emergency Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Emergency Contact Person</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="Contactname">Contact Name</label>
                        <input type="text" class="form-control w-full" id="Contactname" value="{{$employee->contactName}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="ContactNo">Contact Number</label>
                        <input type="text" class="form-control w-full" id="ContactNo" value="{{$employee->contactNo}}">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 my-6">

            <!-- Employment Details Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Employment Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employmentStatus">Status of Employment</label>
                        <select class="form-control w-full" id="employmentStatus">
                            <option value="" selected>{{$employee->employment_status}}</option>
                            <option value="1">Regular</option>
                            <option value="2">Contractual</option>
                            <option value="3">Probationary</option>
                            <option value="4">Consultant & Senior Worker</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employment_date_from">Contract Date From</label>
                        <input type="date" class="form-control w-full" id="employment_date_from" value="{{$employee->employment_date_from}}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employment_date_to">Contract Date To</label>
                        <input type="date" class="form-control w-full" id="employment_date_to" value="{{$employee->employment_date_to}}" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="employee_id">Employee ID</label>
                        <input type="text" class="form-control w-full" id="employee_id" value="{{$employee->employee_id}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="date_hired">Date Hired</label>
                        <input type="date" class="form-control w-full" id="date_hired" value="{{$employee->date_hired}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="department">Group</label>
                        <select id="department" class="form-control w-full" name="department">
                            <option value="{{$employee->department}}" selected>{{$employee->department}}</option>
                            @foreach($department as $departments)
                            <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="sub_department">SubGroup</label>
                        <select id="sub_department" class="form-control w-full" name="sub_department">
                            <option value="{{$employee->position}}" selected>{{$employee->position}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 my-6">

            <!-- Gov ID Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Government Contribution Details & IDs</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="sss_no">SSS Number</label>
                        <input type="number" class="form-control w-full" id="sss_no" value="{{$employee->sss_number}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="phil_health">PhilHealth Number</label>
                        <input type="number" class="form-control w-full" id="phil_health" value="{{$employee->philhealth_number}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="tin">TIN Number</label>
                        <input type="number" class="form-control w-full" id="tin" value="{{$employee->tin_number}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="hdmf">Pag-IBIG Number</label>
                        <input type="number" class="form-control w-full" id="hdmf" value="{{$employee->hdmf_number}}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="ucpb">UCPB Number</label>
                        <input type="number" class="form-control w-full" id="ucpb" value="{{$employee->ucpb_number}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="passport_no">Passport Number</label>
                        <input type="number" class="form-control w-full" id="passport_no" value="{{$employee->passport_number}}">
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="passport_exp">Passport Expiry</label>
                        <input type="date" class="form-control w-full" id="passport_exp" value="{{$employee->passport_exp}}">
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="flex justify-end mt-8 pt-4 border-t border-slate-100">
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors shadow-sm" name="updateAccount" id="updateAccount">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{--salary Modal--}}
<div class="modal fade" tabindex="-1" id="salaryModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Salary & Rates</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="salaryForm" class="space-y-4">
                    <input type="hidden" id="id" name="id" value="{{$employee->id}}">
                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Payroll Type</label>
                        <select id="payroll_type" class="form-control w-full" name="payroll_type">
                            @if($employee->payroll_type == 2)
                                <option value="1" selected>SEMI-MONTHLY</option>
                            @elseif($employee->payroll_type == 1)
                                <option value="2" selected>SEMI-MONTHLY</option>
                            @elseif($employee->payroll_type == 3)
                                <option value="3" selected>WEEKLY</option>
                            @elseif($employee->payroll_type == 4)
                                <option value="4" selected>DAILY</option>
                            @endif
                            <option value="2">MONTHLY</option>
                            <option value="1">SEMI-MONTHLY</option>
                            <option value="3">WEEKLY</option>
                            <option value="4">DAILY</option>
                        </select>
                    </div>
                    
                    <hr class="border-slate-100 my-2">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Basic Pay</label>
                            <input type="number" class="form-control w-full" id="basic_pay" name="basic_pay" value="{{$employee->basic_pay}}">
                        </div>
                        <div class="form-group">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Other NT Pay</label>
                            <input type="number" class="form-control w-full" id="other_nt_pay" name="other_nt_pay" value="{{$employee->other_nt_pay}}">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Cola</label>
                            <input type="number" class="form-control w-full" id="cola" name="cola" value="{{$employee->cola}}">
                        </div>
                        <div class="form-group">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">
                                Vacation Leave <span class="text-blue-500">(days/year)</span>
                            </label>
                            @if($canEditLeave)
                                <input type="number" class="form-control w-full" id="leave" name="leave" value="{{ $vacationBalance }}">
                            @else
                                <div class="bg-slate-100 text-slate-500 text-sm font-medium py-2 px-3 rounded border border-slate-200 cursor-not-allowed">
                                    <i class="fa fa-lock mr-1"></i> Locked ({{ $vacationBalance }} remaining)
                                </div>
                                <input type="hidden" id="leave" name="leave" value="{{ $vacationBalance }}">
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">
                                Sick Leave <span class="text-blue-500">(days/year)</span>
                            </label>
                            @if($canEditLeave)
                                <input type="number" class="form-control w-full" id="sick" name="sick" value="{{ $sickBalance }}">
                            @else
                                <div class="bg-slate-100 text-slate-500 text-sm font-medium py-2 px-3 rounded border border-slate-200 cursor-not-allowed">
                                    <i class="fa fa-lock mr-1"></i> Locked ({{ $sickBalance }} remaining)
                                </div>
                                <input type="hidden" id="sick" name="sick" value="{{ $sickBalance }}">
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_updateSalary">Update</button>
            </div>
        </div>
    </div>
</div>

{{--deduction Modal--}}
<div class="modal fade" id="deductionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deductions Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deductForm" class="space-y-4">
                    <input type="hidden" id="id_deduct" name="id_deduct" value="{{$employee->id}}">
                    <input type="hidden" id="tax" name="tax" value="{{$employee->tax_status}}">
                    <input type="hidden" id="phic_status" name="phic_status" value="{{$employee->phic_status}}">
                    <input type="hidden" id="sss_status" name="sss_status" value="{{$employee->sss_status}}">
                    <input type="hidden" id="pagibig" name="pagibig" value="{{$employee->pag_ibig_contribution}}">
                    
                    <div class="grid grid-cols-4 gap-2 mb-4 bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <label class="inline-flex items-center text-xs font-semibold text-slate-700 cursor-pointer justify-center">
                            <input class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-1.5" type="checkbox" id="tax_deduction" name="tax_deduction">
                            <span>TAX</span>
                        </label>
                        <label class="inline-flex items-center text-xs font-semibold text-slate-700 cursor-pointer justify-center">
                            <input class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-1.5" type="checkbox" id="pagibig_deduction" name="pagibig_deduction">
                            <span>PAG-IBIG</span>
                        </label>
                        <label class="inline-flex items-center text-xs font-semibold text-slate-700 cursor-pointer justify-center">
                            <input class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-1.5" type="checkbox" id="phil_deduction" name="phil_deduction">
                            <span>PHIC</span>
                        </label>
                        <label class="inline-flex items-center text-xs font-semibold text-slate-700 cursor-pointer justify-center">
                            <input class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mr-1.5" type="checkbox" id="sss_deduction" name="sss_deduction">
                            <span>SSS</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1" for="pagibig_amount">HDMF (Pag-IBIG Amount)</label>
                        <input type="number" class="form-control w-full" id="pagibig_amount" name="pagibig_amount" value="{{$employee->pagibig_amount}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="deduction_btn">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/employee.js"></script>
