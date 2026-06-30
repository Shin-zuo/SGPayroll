<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SGPayroll</title>
    <!-- Styles -->

    <!-- CSS -->
   <!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <!-- 
        RTL version
    -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
    
    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false, profileOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-20 w-80 bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col">
            <!-- Brand Area -->
            <div class="flex items-center justify-center h-20 border-b border-slate-200">
                <a href="/" class="text-3xl font-bold text-slate-800 tracking-tight">
                    SGPayroll
                </a>
            </div>
            
            <!-- Sidebar Links -->
            <div class="flex-1 overflow-y-auto py-4">
                @if(auth()->check())
                    @if(auth()->user()->user_type == 2)
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
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10 shrink-0">
                <div class="flex items-center">
                    <!-- Hamburger Toggle Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-md hover:bg-slate-100 text-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-200 mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <!-- Global Search -->
                    <div class="hidden sm:block relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-search text-slate-400"></i>
                        </span>
                        <input type="text" class="h-10 w-64 md:w-96 pl-10 pr-4 rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-colors" placeholder="Search...">
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    <button class="text-slate-400 hover:text-slate-600 focus:outline-none relative">
                        <i class="fa fa-bell text-lg"></i>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    @if(auth()->check())
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 focus:outline-none rounded-full p-1 hover:bg-slate-100 transition-colors">
                            @php
                                $profilePic = null;
                                if (Auth::user()->profile_picture) {
                                    $profilePic = Auth::user()->profile_picture;
                                } else if (Auth::user()->employee && Auth::user()->employee->profile_picture) {
                                    $profilePic = Auth::user()->employee->profile_picture;
                                }
                            @endphp
                            
                            @if($profilePic)
                                <img src="{{ asset('images/profiles/' . $profilePic) }}" alt="Profile" class="h-8 w-8 rounded-full object-cover border border-slate-200">
                            @else
                                <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 border border-slate-300">
                                    <i class="fa fa-user text-sm"></i>
                                </div>
                            @endif
                            <i class="fa fa-chevron-down text-xs text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-slate-100 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'Employee' }}</p>
                            </div>
                            
                            @if(auth()->user()->user_type == 2)
                                <a href="/portal/profile" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                    <i class="fa fa-cog w-5 text-slate-400"></i> Settings
                                </a>
                            @else
                                <a href="/admin/settings" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                    <i class="fa fa-cog w-5 text-slate-400"></i> Settings
                                </a>
                            @endif
                            
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fa fa-sign-out-alt w-5"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-4">
                @yield('content')
            </main>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
</body>
</html>
