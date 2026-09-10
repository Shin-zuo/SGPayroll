<nav class="space-y-1 px-2 py-2">
    <!-- Active Employees -->
    <a href="{{ route('employee') }}" data-tooltip="Active Employees" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('employee') || request()->is('/') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-users w-5 text-center shrink-0 {{ request()->is('employee') || request()->is('/') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Active Employees</span>
    </a>
    
    <!-- Inactive Employees -->
    <a href="/employee/inactive" data-tooltip="Inactive Employees" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('employee/inactive*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-user-slash w-5 text-center shrink-0 {{ request()->is('employee/inactive*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Inactive Employees</span>
    </a>

    <p class="sidebar-heading text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Payroll &amp; Groups</p>

    <!-- Payslip -->
    <a href="/payslip" data-tooltip="Payslip" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('payslip*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-clipboard w-5 text-center shrink-0 {{ request()->is('payslip*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Payslip</span>
    </a>

    <!-- Groups -->
    <a href="/department" data-tooltip="Groups" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('department*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-sitemap w-5 text-center shrink-0 {{ request()->is('department*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Groups</span>
    </a>

    <!-- Previous Payroll -->
    <a href="/edit" data-tooltip="Previous Payroll" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('edit*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fas fa-backward w-5 text-center shrink-0 {{ request()->is('edit*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Previous Payroll</span>
    </a>

    <p class="sidebar-heading text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Management</p>

    <!-- Reports -->
    <a href="/reports" data-tooltip="Reports" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('reports*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fas fa-chart-area w-5 text-center shrink-0 {{ request()->is('reports*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Reports</span>
    </a>

    <!-- Leave Applications -->
    <a href="/leave-applications" data-tooltip="Leave Applications" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('leave-applications*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-calendar-check w-5 text-center shrink-0 {{ request()->is('leave-applications*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Leave Applications</span>
    </a>

    <!-- Settings -->
    <a href="/admin/settings" data-tooltip="Settings" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('admin/settings*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-cog w-5 text-center shrink-0 {{ request()->is('admin/settings*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Settings</span>
    </a>
</nav>