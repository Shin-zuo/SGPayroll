@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Employee Dashboard</h1>
        <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="flex space-x-2">
                <li><a href="#" class="hover:text-slate-800 transition-colors">Home</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800">Dashboard</li>
            </ol>
        </nav>
    </div>

    <!-- Stat Cards (Top Row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Leave Balance -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
            <div class="absolute top-4 left-4 text-blue-500">
                <i class="fa fa-calendar-alt text-lg"></i>
            </div>
            <div class="ml-10">
                <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Leave Balance</h3>
                <p class="text-2xl font-bold text-slate-800">{{ $total_leave_balance }} <span class="text-xs font-medium text-slate-500">Days</span></p>
            </div>
        </div>

        <!-- SSS -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
            <div class="absolute top-4 left-4 text-green-500">
                <i class="fa fa-shield-alt text-lg"></i>
            </div>
            <div class="ml-10">
                <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Total SSS (YTD)</h3>
                <p class="text-2xl font-bold text-slate-800">₱{{ number_format($total_contributions['sss'], 2) }}</p>
            </div>
        </div>

        <!-- PhilHealth -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
            <div class="absolute top-4 left-4 text-teal-500">
                <i class="fa fa-heartbeat text-lg"></i>
            </div>
            <div class="ml-10">
                <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">PhilHealth (YTD)</h3>
                <p class="text-2xl font-bold text-slate-800">₱{{ number_format($total_contributions['philhealth'], 2) }}</p>
            </div>
        </div>

        <!-- Pag-IBIG -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm p-4 relative">
            <div class="absolute top-4 left-4 text-orange-500">
                <i class="fa fa-home text-lg"></i>
            </div>
            <div class="ml-10">
                <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Pag-IBIG (YTD)</h3>
                <p class="text-2xl font-bold text-slate-800">₱{{ number_format($total_contributions['pagibig'], 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Data Tables (Bottom Section) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Payslips -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
                <h2 class="text-base font-semibold text-slate-800">Recent Payslips</h2>
                <a href="/portal/payslips" class="text-xs font-medium text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                            <th class="px-4 py-2 border-b border-slate-200">Period</th>
                            <th class="px-4 py-2 border-b border-slate-200">Net Pay</th>
                            <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPayslips as $slip)
                        <tr class="hover:bg-slate-50 transition-colors bg-white">
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-700">{{ $slip->date_from }} to {{ $slip->date_to }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-bold text-green-600">₱{{ number_format($slip->net_pay, 2) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/portal/payslips/{{ $slip->id }}/download" class="text-slate-400 hover:text-blue-600">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">No recent payslips found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Leave Applications -->
        <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
                <h2 class="text-base font-semibold text-slate-800">Leave Applications</h2>
                <a href="/portal/leave-balance" class="text-xs font-medium text-blue-600 hover:text-blue-800">Apply Leave</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                            <th class="px-4 py-2 border-b border-slate-200">Type</th>
                            <th class="px-4 py-2 border-b border-slate-200">Dates</th>
                            <th class="px-4 py-2 border-b border-slate-200 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($applications as $app)
                        <tr class="hover:bg-slate-50 transition-colors bg-white">
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-800">{{ ucfirst($app->leave_type) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{ $app->date_from }} to {{ $app->date_to }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-right">
                                @if($app->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($app->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">No recent leave applications.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
