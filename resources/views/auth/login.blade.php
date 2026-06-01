<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center font-sans antialiased">

<div class="w-full max-w-md p-6">
    <!-- Logo / Brand Placeholder -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white mb-4 shadow-lg shadow-blue-200">
            <i class="fa fa-fingerprint text-3xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">SG Payroll</h2>
        <p class="text-slate-500 text-sm mt-1">Please sign in to your account</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                @if ($errors->has('email') || $errors->has('password'))
                    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200 flex items-start gap-3">
                        <i class="fa fa-exclamation-circle text-red-500 mt-0.5"></i>
                        <div class="text-red-700 text-sm">
                            @if ($errors->has('email'))
                                <p>{{ $errors->first('email') }}</p>
                            @endif
                            @if ($errors->has('password'))
                                <p>{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-2" for="email">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input id="email" type="email" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-slate-700" for="password">Password</label>
                        <a href="{{ route('password.request') ?? '#' }}" class="text-xs font-medium text-blue-600 hover:text-blue-700 transition-colors">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" type="password" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 text-sm font-medium text-slate-700 cursor-pointer">Remember me</label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm transition-all flex items-center justify-center gap-2">
                    Sign In <i class="fa fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 text-center">
            <p class="text-sm text-slate-500">
                Don't have an account? <a href="#" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">Sign up</a>
            </p>
        </div>
    </div>

    <div class="mt-8 text-center text-slate-400 text-xs">
        &copy; {{ date('Y') }} SG Payroll System. All rights reserved.
    </div>
</div>

</body>
</html>
