@extends('layouts.app')
@section('title', 'My Loans')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">My Loans</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
            <h3 class="text-base font-semibold text-slate-800">Active and Previous Loans</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Loan Type</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                        <th class="px-6 py-4 text-center">Date Granted</th>
                        <th class="px-6 py-4 text-right">Deduction</th>
                        <th class="px-6 py-4 text-center">Remaining Term</th>
                        <th class="px-6 py-4 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-200">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-800">{{ $loan->loan_name }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-medium text-slate-800">
                            ₱{{ number_format($loan->loan_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center text-slate-500">
                            {{ $loan->loan_date ? \Carbon\Carbon::parse($loan->loan_date)->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right text-red-600 font-medium">
                            ₱{{ number_format($loan->deduction, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($loan->remaining_term > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $loan->remaining_term }} {{ str_plural('period', $loan->remaining_term) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Paid Off
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-800">
                            ₱{{ number_format($loan->balance, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            <i class="fa fa-info-circle text-slate-400 text-3xl mb-3 block"></i>
                            <p class="text-base font-medium">No loans found</p>
                            <p class="text-sm mt-1">You don't have any active or previous loans.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
