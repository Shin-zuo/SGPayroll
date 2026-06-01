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