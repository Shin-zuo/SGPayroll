<nav class="space-y-1 px-2 py-2">
    <!-- Leave Window -->
    <a href="/superadmin/leave-window" data-tooltip="Leave Window" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('superadmin/leave-window*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-calendar-alt w-5 text-center shrink-0 {{ request()->is('superadmin/leave-window*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Leave Window</span>
    </a>

    <p class="sidebar-heading text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-1.5">Settings</p>

    <!-- Settings -->
    <a href="/admin/settings" data-tooltip="Settings" class="sidebar-nav-item group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('admin/settings*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
        <i class="sidebar-icon fa fa-cog w-5 text-center shrink-0 {{ request()->is('admin/settings*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}"></i>
        <span class="sidebar-label whitespace-nowrap overflow-hidden text-ellipsis">Settings</span>
    </a>
</nav>

