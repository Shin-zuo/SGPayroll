<nav class="space-y-1 px-3 py-2">
    <!-- Active Employees -->
    <a href="{{ route('employee') }}" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('employee') || request()->is('/') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-users w-5 text-center {{ request()->is('employee') || request()->is('/') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Active Employees</span>
    </a>
    
    <!-- Inactive Employees -->
    <a href="/employee/inactive" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('employee/inactive*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-user-slash w-5 text-center {{ request()->is('employee/inactive*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Inactive Employees</span>
    </a>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Payroll &amp; Groups</p>

    <!-- Payslip -->
    <a href="/payslip" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('payslip*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-clipboard w-5 text-center {{ request()->is('payslip*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Payslip</span>
    </a>

    <!-- Groups -->
    <a href="/department" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('department*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-sitemap w-5 text-center {{ request()->is('department*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Groups</span>
    </a>

    <!-- Previous Payroll -->
    <a href="/edit" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('edit*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fas fa-backward w-5 text-center {{ request()->is('edit*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Previous Payroll</span>
    </a>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Management</p>

    <!-- Reports -->
    <a href="/reports" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('reports*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fas fa-chart-area w-5 text-center {{ request()->is('reports*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Reports</span>
    </a>

    <!-- Leave Applications -->
    <a href="/leave-applications" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('leave-applications*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-calendar-check w-5 text-center {{ request()->is('leave-applications*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Leave Applications</span>
    </a>

    <!-- Settings -->
    <a href="/admin/settings" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('admin/settings*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-cog w-5 text-center {{ request()->is('admin/settings*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Settings</span>
    </a>
</nav>