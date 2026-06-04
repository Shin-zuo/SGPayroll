@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">My Payslips</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="/portal" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Payslips</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-base font-semibold text-slate-800">Payslip History</h2>
        <a href="/portal" class="text-xs font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <th class="px-4 py-2 border-b border-slate-200">Payroll Number</th>
                    <th class="px-4 py-2 border-b border-slate-200">Period</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Gross Pay</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Net Pay</th>
                    <th class="px-4 py-2 border-b border-slate-200 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $payroll)
                <tr class="hover:bg-slate-50 transition-colors bg-white">
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-slate-800">{{ $payroll->payroll_number }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-slate-500">{{ $payroll->date_from }} to {{ $payroll->date_to }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm text-slate-500">₱{{ number_format($payroll->gross_pay, 2) }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-bold text-green-600">₱{{ number_format($payroll->net_pay, 2) }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/portal/payslips/{{ $payroll->id }}/download" class="inline-flex items-center px-2.5 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <i class="fa fa-download mr-1"></i> PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">
                        <i class="fa fa-file-invoice-dollar text-3xl text-slate-300 mb-2 block"></i>
                        No payslip history found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
