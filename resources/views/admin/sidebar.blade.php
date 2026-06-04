<<<<<<< HEAD
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li>
            <a href="#menu-toggle"  id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i> Collapse </a>
        </li>
        <hr>
        <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-user" aria-hidden="true"></i> Employee</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="/employee" target="_blank">Active</a>
                </li>
                <li>
                    <a href="/employee/inactive">Inactive</a>
                </li>
                <li>
                    <a href="/employee/upload-employees">Upload File</a>
                </li>
            </ul>
        </li>
        <hr>
        <li>
            <a href="/payslip" target="_blank"><i class="fa fa-clipboard" aria-hidden="true"></i> Payslip</a>
        </li>
        <hr>
    <li>
        <a href="/department" target="_blank"><i class="fa fa-users" aria-hidden="true"></i> Groups</a>
    </li>
        <hr>
        <li>
            <a href="#prevPayroll" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-backward"></i> Previous Payroll</a>
            <ul class="collapse list-unstyled" id="prevPayroll">
                <li>
                    <a href="/edit" target="_blank">Edit</a>
                </li>
            </ul>
        </li>
        <hr>
    <li>
        <a href="/reports" target="_blank"><i class="fas fa-chart-area"></i> Reports</a>
    </li>
        <hr>
        <li>
            <a href="/quick-payroll" target="_blank"><i class="fas fa-chart-area"></i> Quick Payroll</a>
        </li>
                {{--<li>--}}
                    {{--<a href="/edit" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> Edit Previous Payroll </a>--}}
                {{--</li>--}}

    </ul>

</div>
=======
<nav class="space-y-1 px-4 py-4">
    <!-- Dashboard / Active -->
    <a href="{{ route('employee') }}" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-700 transition-colors">
        <i class="fa fa-users text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Active Employees</span>
    </a>
    
    <a href="/employee/inactive" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fa fa-user-slash text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Inactive Employees</span>
    </a>

    <p class="px-5 text-sm font-bold text-slate-400 uppercase tracking-wider mt-8 mb-3">Payroll &amp; Groups</p>

    <a href="/payslip" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fa fa-clipboard text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Payslip</span>
    </a>

    <a href="/department" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fa fa-sitemap text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Groups</span>
    </a>

    <a href="/edit" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fas fa-backward text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Previous Payroll</span>
    </a>

    <p class="px-5 text-sm font-bold text-slate-400 uppercase tracking-wider mt-8 mb-3">Management</p>

    <a href="/reports" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fas fa-chart-area text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Reports</span>
    </a>

    <a href="/leave-applications" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fa fa-calendar-check text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Leave Applications</span>
    </a>

    <a href="/admin/settings" class="group flex items-center px-5 py-4 text-base font-medium rounded-lg hover:bg-blue-50 hover:text-blue-600 text-slate-500 transition-colors">
        <i class="fa fa-cog text-lg w-6 text-center text-slate-400 group-hover:text-blue-500"></i>
        <span class="ml-4">Settings</span>
    </a>
</nav>
>>>>>>> branch1
