<nav class="space-y-1 px-3 py-2">
    <!-- Dashboard -->
    <a href="/portal" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-tachometer-alt w-5 text-center {{ request()->is('portal') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Dashboard</span>
    </a>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">My Records</p>

    <!-- My Payslips -->
    <a href="/portal/payslips" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal/payslips*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-money-bill-alt w-5 text-center {{ request()->is('portal/payslips*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>My Payslips</span>
    </a>

    <!-- Leave Applications -->
    <a href="/portal/leave-balance" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal/leave-balance*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-calendar-alt w-5 text-center {{ request()->is('portal/leave-balance*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Leave Applications</span>
    </a>

    <!-- Gov. Contributions -->
    <a href="/portal/contributions" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal/contributions*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-university w-5 text-center {{ request()->is('portal/contributions*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Gov. Contributions</span>
    </a>

    <!-- My Loans -->
    <a href="/portal/loans" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal/loans*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-credit-card w-5 text-center {{ request()->is('portal/loans*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>My Loans</span>
    </a>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Settings</p>

    <!-- Profile Settings -->
    <a href="/portal/profile" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('portal/profile*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-cog w-5 text-center {{ request()->is('portal/profile*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Profile Settings</span>
    </a>
</nav>
