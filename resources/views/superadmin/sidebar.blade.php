<nav class="space-y-1 px-3 py-2">
    <!-- Leave Window -->
    <a href="/superadmin/leave-window" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('superadmin/leave-window*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-calendar-alt w-5 text-center {{ request()->is('superadmin/leave-window*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Leave Window</span>
    </a>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Settings</p>

    <!-- Settings -->
    <a href="/admin/settings" class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('admin/settings*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="fa fa-cog w-5 text-center {{ request()->is('admin/settings*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span>Settings</span>
    </a>
</nav>
