@extends('layouts.app')

@section('content')
<div class="flex justify-center p-6">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                <h4 class="text-lg font-bold text-[#192965] m-0">Register</h4>
            </div>

            <div class="p-8">
                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input id="name" type="text" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('name') ? 'border-red-500 bg-red-50' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-Mail Address</label>
                        <input id="email" type="email" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('email') ? 'border-red-500 bg-red-50' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('password') ? 'border-red-500 bg-red-50' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" name="password_confirmation" required>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="w-full bg-[#192965] hover:bg-blue-800 text-white font-medium py-2 px-6 rounded-md transition-colors flex items-center justify-center gap-2">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
