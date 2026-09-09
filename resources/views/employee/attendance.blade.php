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

<div class="admin-table-card mb-6">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-clock-o"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Work Hours Log</h2>
                    <span class="admin-table-badge">{{ count($time_sheet) }} entries</span>
                </div>
                <p class="text-xs text-slate-400">Daily attendance and logged work durations</p>
            </div>
        </div>
        <div>
            <a href="{{ route('employee') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200/80 rounded-lg transition-colors">
                <i class="fa fa-arrow-left text-[10px]"></i> Back to Directory
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date Logged</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th class="text-right">Duration (Hrs)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($time_sheet as $time_sheets)
                <tr>
                    <td class="whitespace-nowrap font-medium text-slate-800">{{$time_sheets->date_log}}</td>
                    <td class="whitespace-nowrap text-slate-600">{{$time_sheets->time_in}}</td>
                    <td class="whitespace-nowrap text-slate-600">{{$time_sheets->time_out}}</td>
                    <td class="whitespace-nowrap text-right font-bold text-slate-800">{{$time_sheets->duration}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <i class="fa fa-clock-o text-lg"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-600">No attendance logs found</p>
                        <p class="text-xs text-slate-400 mt-1">There are no work hour records logged for this employee yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
