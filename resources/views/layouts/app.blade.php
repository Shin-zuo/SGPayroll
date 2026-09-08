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
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">

    <!-- Core Scripts (jQuery, Bootstrap plugins, DataTables, Alertify) -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
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
                    <div class="hidden sm:block relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                            <i class="fa fa-search text-xs"></i>
                        </span>
                        <input type="text" class="h-9 w-64 md:w-80 pl-8 pr-3 rounded-lg border border-slate-200 bg-slate-50/50 focus:bg-white text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-50 transition-all" placeholder="Quick search records, employees...">
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-3">
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors relative">
                        <i class="fa fa-bell text-sm"></i>
                        <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </button>

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
    @yield('scripts')
    @stack('scripts')
</body>
</html>
