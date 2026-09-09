@extends('layouts.app')
@section('content')
  
<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Salaries</h1>
        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Base compensation and salary records</p>
    </div>
    <nav class="text-xs font-medium text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1.5">
            <li><a href="/" class="hover:text-slate-700 transition-colors">Home</a></li>
            <li><i class="fa fa-chevron-right text-[10px] text-slate-300"></i></li>
            <li class="text-slate-800 font-semibold">Salary</li>
        </ol>
    </nav>
</div>

<!-- Table Card -->
<div class="admin-table-card mb-8">
    <div class="admin-table-header">
        <div class="flex items-center gap-3">
            <div class="admin-table-icon">
                <i class="fa fa-money"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-800">Salary Directory</h2>
                    <span class="admin-table-badge">{{ count($employee_salary) }} records</span>
                </div>
                <p class="text-xs text-slate-400">Employee basic salaries and pay rate definitions</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="p-4 border-b border-slate-100 bg-slate-50/50">
        <form action="/salary" method="GET" class="max-w-md">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 text-xs">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" class="form-control pl-8 w-full text-xs" id="search" placeholder="Search by name (e.g. Dela Cruz, Juan)..." name="search" value="{{ request('search') }}">
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-right">Basic Pay</th>
                    <th class="text-center">Overtime</th>
                    <th class="text-center">Cash Advance</th>
                    <th class="text-center">Others</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employee_salary as $employee_salaries)
                    <tr>
                        <td class="font-semibold text-slate-800">{{ $employee_salaries->full_name }}</td>
                        <td class="text-right font-mono text-xs font-bold text-slate-800">₱{{ number_format($employee_salaries->basic_pay, 2) }}</td>
                        <td class="text-center text-xs text-slate-400">-</td>
                        <td class="text-center text-xs text-slate-400">-</td>
                        <td class="text-center text-xs text-slate-400">-</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa fa-money text-lg"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-600">No salary records found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
 
@endsection