<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SGPayroll</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alertify CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Icons & Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>

    <!-- Compiled Tailwind CSS -->
    <link href="{{ asset('css/tailwind.css') }}?v={{ file_exists(public_path('css/tailwind.css')) ? filemtime(public_path('css/tailwind.css')) : time() }}" rel="stylesheet">

    <!-- Core Scripts (jQuery, Bootstrap plugins, DataTables, Alertify) -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script>
        if (window.jQuery && $.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"<"flex-1"l><"flex-1 text-right"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"<"flex-1"i><"flex-1 text-right"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ records",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "Showing 0 to 0 of 0 records",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        previous: '<i class="fa fa-chevron-left text-[10px] mr-1"></i> Prev',
                        next: 'Next <i class="fa fa-chevron-right text-[10px] ml-1"></i>'
                    }
                }
            });
        }
    </script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50/50 font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false, profileOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200/80 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shrink-0 shadow-xs">
            <!-- Brand Area -->
            <div class="flex items-center justify-between h-16 px-5 border-b border-slate-100">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm shadow-blue-500/20">
                        SG
                    </div>
                    <span class="text-base font-bold text-slate-900 tracking-tight">SGPayroll</span>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                    <i class="fa fa-times text-sm"></i>
                </button>
            </div>
            
            <!-- Sidebar Links -->
            <div class="flex-1 overflow-y-auto py-3">
                @if(auth()->check())
                    @if(auth()->user()->user_type == 0)
                        @include('superadmin.sidebar')
                    @elseif(auth()->user()->user_type == 2)
                        @include('portal.sidebar')
                    @else
                        @include('admin.sidebar')
                    @endif
                @endif
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-16 bg-white/90 backdrop-blur-sm border-b border-slate-200/80 flex items-center justify-between px-6 sticky top-0 z-20 shrink-0">
                <div class="flex items-center">
                    <!-- Hamburger Toggle Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-100 mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <!-- Global Search -->
                    <!-- <div class="hidden sm:block relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                            <i class="fa fa-search text-xs"></i>
                        </span>
                        <input type="text" class="h-9 w-64 md:w-80 pl-8 pr-3 rounded-lg border border-slate-200 bg-slate-50/50 focus:bg-white text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-50 transition-all" placeholder="Quick search records, employees...">
                    </div> -->
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-3">
                    @if(auth()->check())
                    <!-- Notification Bell Dropdown -->
                    <div class="relative" x-data="notificationDropdown()" x-init="init()">
                        <button 
                            @click="toggleDropdown()" 
                            type="button"
                            class="relative w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none"
                            :class="{ 'bg-slate-100 text-slate-600': isOpen }"
                            aria-label="Notifications"
                        >
                            <i class="fa fa-bell text-sm"></i>
                            <template x-if="unreadCount > 0">
                                <span 
                                    class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-white shadow-sm"
                                    x-text="unreadCount > 99 ? '99+' : unreadCount"
                                ></span>
                            </template>
                        </button>

                        <!-- Notification Dropdown Menu -->
                        <div 
                            x-show="isOpen" 
                            @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden flex flex-col max-h-[480px]"
                            style="display: none;"
                        >
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifications</h3>
                                    <template x-if="unreadCount > 0">
                                        <span class="px-2 py-0.5 text-[10px] font-semibold bg-blue-100 text-blue-700 rounded-full" x-text="unreadCount + ' new'"></span>
                                    </template>
                                </div>
                                <div class="flex items-center space-x-2 text-xs">
                                    <template x-if="unreadCount > 0">
                                        <button 
                                            @click.stop="markAllAsRead()" 
                                            type="button"
                                            class="text-blue-600 hover:text-blue-700 text-[11px] font-medium transition-colors hover:underline"
                                        >
                                            Mark all read
                                        </button>
                                    </template>
                                    <template x-if="notifications.length > 0">
                                        <button 
                                            @click.stop="clearAll()" 
                                            type="button"
                                            class="text-slate-400 hover:text-rose-600 text-[11px] font-medium transition-colors hover:underline flex items-center"
                                            title="Clear all notifications"
                                        >
                                            <i class="fa fa-trash-can mr-1 text-[10px]"></i> Clear all
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Notification Items List -->
                            <div class="overflow-y-auto flex-1 divide-y divide-slate-100/80">
                                <!-- Loading State -->
                                <template x-if="loading && notifications.length === 0">
                                    <div class="p-8 text-center text-slate-400">
                                        <i class="fa fa-spinner fa-spin text-xl mb-2 text-blue-500"></i>
                                        <p class="text-xs">Loading notifications...</p>
                                    </div>
                                </template>

                                <!-- Empty State -->
                                <template x-if="!loading && notifications.length === 0">
                                    <div class="p-8 text-center">
                                        <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                            <i class="fa fa-bell-slash text-base"></i>
                                        </div>
                                        <p class="text-xs font-semibold text-slate-700">No notifications yet</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">You're all caught up!</p>
                                    </div>
                                </template>

                                <!-- Items -->
                                <template x-for="item in notifications" :key="item.id">
                                    <div 
                                        @click="clickNotification(item)" 
                                        class="group relative p-3.5 flex items-start space-x-3 transition-colors cursor-pointer hover:bg-slate-50/90"
                                        :class="item.is_read ? 'bg-white' : 'bg-blue-50/50'"
                                    >
                                        <!-- Type Icon -->
                                        <div class="shrink-0 mt-0.5">
                                            <template x-if="item.type === 'leave_application'">
                                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xs shadow-xs">
                                                    <i class="fa fa-calendar-alt"></i>
                                                </div>
                                            </template>
                                            <template x-if="item.type === 'leave_status'">
                                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs shadow-xs">
                                                    <i class="fa fa-clipboard-check"></i>
                                                </div>
                                            </template>
                                            <template x-if="item.type === 'new_payslip'">
                                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xs shadow-xs">
                                                    <i class="fa fa-file-invoice-dollar"></i>
                                                </div>
                                            </template>
                                            <template x-if="!['leave_application', 'leave_status', 'new_payslip'].includes(item.type)">
                                                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-xs shadow-xs">
                                                    <i class="fa fa-bell"></i>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Text Details -->
                                        <div class="flex-1 min-w-0 pr-1">
                                            <div class="flex items-center space-x-1.5">
                                                <h4 class="text-xs font-semibold text-slate-900 truncate" x-text="item.title"></h4>
                                                <template x-if="!item.is_read">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 shrink-0"></span>
                                                </template>
                                            </div>
                                            <p class="text-[11px] text-slate-600 leading-snug mt-0.5 line-clamp-2" x-text="item.message"></p>
                                            <div class="flex items-center space-x-1 text-[10px] text-slate-400 mt-1.5">
                                                <i class="fa fa-clock text-[9px]"></i>
                                                <span x-text="item.time_ago"></span>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <button 
                                            @click.stop="deleteNotification(item.id)" 
                                            type="button" 
                                            class="shrink-0 p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors opacity-70 group-hover:opacity-100 focus:opacity-100"
                                            title="Delete notification"
                                            aria-label="Delete notification"
                                        >
                                            <i class="fa fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer -->
                            <template x-if="notifications.length > 0">
                                <div class="px-4 py-2 border-t border-slate-100 bg-slate-50/40 text-center">
                                    <p class="text-[10px] text-slate-400">Click a notification to view details</p>
                                </div>
                            </template>
                        </div>
                    </div>
                    @endif

                    @if(auth()->check())
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2.5 focus:outline-none rounded-lg p-1.5 hover:bg-slate-50 border border-transparent hover:border-slate-200/70 transition-all">
                            @php
                                $profilePic = null;
                                if (Auth::user()->profile_picture) {
                                    $profilePic = Auth::user()->profile_picture;
                                } else if (Auth::user()->employee && Auth::user()->employee->profile_picture) {
                                    $profilePic = Auth::user()->employee->profile_picture;
                                }
                            @endphp
                            
                            @if($profilePic)
                                <img src="{{ asset('images/profiles/' . $profilePic) }}" alt="Profile" class="h-7 w-7 rounded-full object-cover ring-1 ring-slate-200">
                            @else
                                <div class="h-7 w-7 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-semibold ring-1 ring-slate-200">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:inline-block text-xs font-medium text-slate-700 max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fa fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg py-1.5 border border-slate-100 z-50" style="display: none;">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-semibold text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ Auth::user()->email ?? 'Employee' }}</p>
                            </div>
                            
                            <div class="py-1">
                                @if(auth()->user()->user_type == 2)
                                    <a href="/portal/profile" class="flex items-center px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <i class="fa fa-cog w-4 mr-2 text-slate-400"></i> Settings
                                    </a>
                                @else
                                    <a href="/admin/settings" class="flex items-center px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <i class="fa fa-cog w-4 mr-2 text-slate-400"></i> Settings
                                    </a>
                                @endif
                                
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50/70 transition-colors">
                                    <i class="fa fa-sign-out-alt w-4 mr-2"></i> Logout
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50/50 p-6 lg:p-8">
                <div class="max-w-7xl mx-auto w-full">
                    @yield('content')
                </div>
            </main>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    @if(auth()->check())
    <script>
        function notificationDropdown() {
            return {
                isOpen: false,
                notifications: [],
                unreadCount: 0,
                loading: false,

                init() {
                    this.fetchNotifications();
                    setInterval(() => {
                        this.fetchNotifications(true);
                    }, 45000);
                },

                toggleDropdown() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen && this.notifications.length === 0) {
                        this.fetchNotifications();
                    }
                },

                fetchNotifications(silent = false) {
                    if (!silent) this.loading = true;
                    fetch('/notifications', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response error');
                        return res.json();
                    })
                    .then(data => {
                        this.unreadCount = data.unread_count || 0;
                        if (!this.isOpen || this.notifications.length === 0) {
                            this.notifications = data.notifications || [];
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching notifications:', err);
                    })
                    .finally(() => {
                        if (!silent) this.loading = false;
                    });
                },

                clickNotification(item) {
                    if (!item.is_read) {
                        item.is_read = true;
                        if (this.unreadCount > 0) this.unreadCount--;
                        this.markAsRead(item.id);
                    }
                    if (item.link) {
                        window.location.href = item.link;
                    }
                },

                markAsRead(id) {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data && typeof data.unread_count !== 'undefined') {
                            this.unreadCount = data.unread_count;
                        }
                    })
                    .catch(err => console.error('Error marking notification as read:', err));
                },

                markAllAsRead() {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    this.notifications.forEach(n => n.is_read = true);
                    this.unreadCount = 0;

                    fetch('/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.unreadCount = 0;
                    })
                    .catch(err => console.error('Error marking all as read:', err));
                },

                deleteNotification(id) {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const target = this.notifications.find(n => n.id === id);
                    if (target && !target.is_read && this.unreadCount > 0) {
                        this.unreadCount--;
                    }
                    this.notifications = this.notifications.filter(n => n.id !== id);

                    fetch(`/notifications/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data && typeof data.unread_count !== 'undefined') {
                            this.unreadCount = data.unread_count;
                        }
                    })
                    .catch(err => console.error('Error deleting notification:', err));
                },

                clearAll() {
                    if (!confirm('Are you sure you want to clear all notifications?')) return;
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    this.notifications = [];
                    this.unreadCount = 0;

                    fetch('/notifications/clear-all', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.unreadCount = 0;
                        this.notifications = [];
                    })
                    .catch(err => console.error('Error clearing notifications:', err));
                }
            };
        }
        window.notificationDropdown = notificationDropdown;
        document.addEventListener('alpine:init', () => {
            if (window.Alpine) {
                window.Alpine.data('notificationDropdown', notificationDropdown);
            }
        });
    </script>
    @endif
    @yield('scripts')
    @stack('scripts')
</body>
</html>
