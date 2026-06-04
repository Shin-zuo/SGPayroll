@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Government Contributions</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="/portal" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Contributions</li>
        </ol>
    </nav>
</div>

<!-- Yearly Summaries -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @forelse($yearlyContributions as $year => $totals)
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm border-t-4 border-t-blue-600 p-6">
        <div class="text-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">{{ $year }} Summary</h3>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
                <span class="font-medium text-slate-500">SSS</span>
                <span class="font-bold text-slate-800">₱{{ number_format($totals['sss'], 2) }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="font-medium text-slate-500">PhilHealth</span>
                <span class="font-bold text-slate-800">₱{{ number_format($totals['philhealth'], 2) }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="font-medium text-slate-500">Pag-IBIG</span>
                <span class="font-bold text-slate-800">₱{{ number_format($totals['pagibig'], 2) }}</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
            <span class="font-bold text-slate-800">Total</span>
            <span class="font-bold text-green-600 text-lg">₱{{ number_format($totals['sss'] + $totals['philhealth'] + $totals['pagibig'], 2) }}</span>
        </div>
    </div>
    @empty
    <div class="col-span-3 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg flex items-center">
        <i class="fa fa-info-circle mr-2"></i> No contribution history found.
    </div>
    @endforelse
</div>

<!-- Detailed Breakdown -->
<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-lg font-semibold text-slate-800">Detailed Breakdown by Payroll Period</h2>
        <a href="/portal" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-6 py-3 border-b border-slate-200">Period</th>
                    <th class="px-6 py-3 border-b border-slate-200 text-right">SSS</th>
                    <th class="px-6 py-3 border-b border-slate-200 text-right">PhilHealth</th>
                    <th class="px-6 py-3 border-b border-slate-200 text-right">Pag-IBIG</th>
                    <th class="px-6 py-3 border-b border-slate-200 text-right">Total Deducted</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $payroll)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $payroll->date_from }} to {{ $payroll->date_to }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-slate-500">₱{{ number_format($payroll->sss_contribution, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-slate-500">₱{{ number_format($payroll->phic_contribution, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-slate-500">₱{{ number_format($payroll->hdmf_contribution, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-red-500">
                        -₱{{ number_format($payroll->sss_contribution + $payroll->phic_contribution + $payroll->hdmf_contribution, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No detailed records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
