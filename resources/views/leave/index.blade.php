@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Leave Applications</h1>
        <p class="text-sm text-slate-500 mt-0.5">Review, approve, or reject employee leave requests and track leave balances.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100 shadow-sm">
            <i class="fas fa-calendar-check"></i> {{ $applications->count() }} Total Requests
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-100 shadow-sm">
            <i class="fas fa-clock"></i> {{ $applications->where('status', 'pending')->count() }} Pending
        </span>
    </div>
</div>

@if(session()->has('success'))
    <div class="mb-4 rounded-lg bg-emerald-50 p-4 border border-emerald-200 flex items-start gap-3 relative">
        <i class="fa fa-check-circle text-emerald-500 mt-0.5"></i>
        <div class="text-emerald-700 flex-1 text-sm font-medium">{{ session()->get('success') }}</div>
        <button type="button" class="text-emerald-500 hover:text-emerald-700 absolute right-4 top-4" onclick="this.parentElement.style.display='none'">
            <i class="fa fa-times"></i>
        </button>
    </div>
@endif
@if(session()->has('error'))
    <div class="mb-4 rounded-lg bg-rose-50 p-4 border border-rose-200 flex items-start gap-3 relative">
        <i class="fa fa-exclamation-circle text-rose-500 mt-0.5"></i>
        <div class="text-rose-700 flex-1 text-sm font-medium">{{ session()->get('error') }}</div>
        <button type="button" class="text-rose-500 hover:text-rose-700 absolute right-4 top-4" onclick="this.parentElement.style.display='none'">
            <i class="fa fa-times"></i>
        </button>
    </div>
@endif

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-8">
    <div class="bg-slate-50/80 dark:bg-slate-900/60 px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shadow-xs">
                    <i class="fas fa-calendar-alt"></i>
                </span>
                Leave Applications Directory
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Sorted newest at top. Search by employee, type, or date range.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-transparent dark:border-slate-700/60 text-xs font-semibold">
                {{ $applications->count() }} records
            </span>
        </div>
    </div>

    <div class="p-5 overflow-x-auto">
        <table id="leavetable" class="w-full text-left border-collapse" style="font-size: 12px;">
            <thead>
                <tr class="bg-slate-100/75 dark:bg-slate-800/80 font-semibold text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <th class="py-2.5 px-3" style="width: 55px;">Ref #</th>
                    <th class="py-2.5 px-3">Employee</th>
                    <th class="py-2.5 px-3">Type</th>
                    <th class="py-2.5 px-3">Period</th>
                    <th class="py-2.5 px-3 text-center">Days</th>
                    <th class="py-2.5 px-3">Reason</th>
                    <th class="py-2.5 px-3 text-center">Status</th>
                    <th class="py-2.5 px-3 text-center" style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($applications as $app)
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="py-2.5 px-3 font-mono text-slate-500 dark:text-slate-300" style="font-size: 11px;">#{{$app->id}}</td>
                    <td class="py-2.5 px-3">
                        <div class="font-semibold text-slate-800 dark:text-white" style="font-size: 12px;">{{$app->employee ? strtoupper($app->employee->full_name) : 'UNKNOWN'}}</div>
                        <div class="text-slate-400 dark:text-slate-300 font-mono" style="font-size: 10px;">{{$app->employee ? $app->employee->employee_id : '—'}}</div>
                    </td>
                    <td class="py-2.5 px-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/60">
                            {{ ucfirst($app->leave_type) }}
                        </span>
                    </td>
                    <td class="py-2.5 px-3 text-slate-700 dark:text-slate-100 font-medium whitespace-nowrap" style="font-size: 11px;">
                        {{ $app->date_from }} to {{ $app->date_to }}
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-slate-100" style="font-size: 12px;">{{ $app->total_days }}</td>
                    <td class="py-2.5 px-3 text-slate-600 dark:text-slate-300 max-w-xs truncate" title="{{ $app->reason }}">{{ $app->reason }}</td>
                    <td class="py-2.5 px-3 text-center">
                        @if($app->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60">Pending</span>
                        @elseif($app->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">Approved</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60">Rejected</span>
                        @endif
                    </td>
                    <td class="py-2.5 px-3 text-center">
                        @if($app->status === 'pending')
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="/leave-applications/approve/{{$app->id}}" class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold rounded-md {{ $app->can_approve ? 'text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs' : 'text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 cursor-not-allowed border border-slate-200 dark:border-slate-700' }} transition-colors" {!! $app->can_approve ? '' : 'disabled onclick="return false;"' !!} title="{{ $app->can_approve ? 'Approve' : 'Insufficient leave credits (Remaining: '.$app->remaining.')' }}" {!! $app->can_approve ? 'onclick="return confirm(\'Are you sure you want to approve this application?\')"' : '' !!}>
                                    <i class="fa fa-check mr-1"></i> Approve
                                </a>
                                <a href="/leave-applications/reject/{{$app->id}}" class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold rounded-md text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition-colors" onclick="return confirm('Are you sure you want to reject this application?')">
                                    <i class="fa fa-times mr-1"></i> Reject
                                </a>
                            </div>
                        @else
                            <span class="text-slate-400 dark:text-slate-500 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#leavetable').DataTable({
            order: [[0, 'desc']],
            dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"<"flex-1"l><"flex-1 text-right"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"<"flex-1"i><"flex-1 text-right"p>>',
        });
    });
</script>
@endsection
