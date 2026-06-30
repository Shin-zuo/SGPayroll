@extends('layouts.app')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Attendance Log</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Employees</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Attendance</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-base font-semibold text-slate-800">Work Hours Log</h2>
        <a href="{{ route('employee') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fa fa-arrow-left mr-1.5"></i> Back to Directory
        </a>
    </div>
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2.5 border-b border-slate-200">Date Logged</th>
                    <th class="px-4 py-2.5 border-b border-slate-200">Time In</th>
                    <th class="px-4 py-2.5 border-b border-slate-200">Time Out</th>
                    <th class="px-4 py-2.5 border-b border-slate-200 text-right">Duration (Hrs)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($time_sheet as $time_sheets)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$time_sheets->date_log}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$time_sheets->time_in}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{$time_sheets->time_out}}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-semibold text-slate-800">{{$time_sheets->duration}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                        <i class="fa fa-clock text-3xl text-slate-300 mb-2 block"></i>
                        No attendance logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
