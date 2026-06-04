@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-[#192965] flex items-center gap-2">
            <i class="fa fa-calendar-check"></i> Leave Applications
        </h1>
    </div>

    @if(session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 border border-green-200 flex items-start gap-3 relative">
            <i class="fa fa-check-circle text-green-500 mt-0.5"></i>
            <div class="text-green-700 flex-1">{{ session()->get('success') }}</div>
            <button type="button" class="text-green-500 hover:text-green-700 absolute right-4 top-4" onclick="this.parentElement.style.display='none'">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 border border-red-200 flex items-start gap-3 relative">
            <i class="fa fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div class="text-red-700 flex-1">{{ session()->get('error') }}</div>
            <button type="button" class="text-red-500 hover:text-red-700 absolute right-4 top-4" onclick="this.parentElement.style.display='none'">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 overflow-x-auto">
            <table id="leavetable" class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">ID</th>
                        <th class="px-4 py-3 font-semibold">Employee</th>
                        <th class="px-4 py-3 font-semibold">Type</th>
                        <th class="px-4 py-3 font-semibold">Dates</th>
                        <th class="px-4 py-3 font-semibold text-center">Total Days</th>
                        <th class="px-4 py-3 font-semibold">Reason</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($applications as $app)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-600">{{$app->id}}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{$app->employee ? strtoupper($app->employee->full_name) : 'UNKNOWN'}}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($app->leave_type) }} Leave</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $app->date_from }} to {{ $app->date_to }}</td>
                        <td class="px-4 py-3 text-center text-gray-600">{{ $app->total_days }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $app->reason }}">{{ $app->reason }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($app->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($app->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($app->status === 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/leave-applications/approve/{{$app->id}}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-md {{ $app->can_approve ? 'text-white bg-green-600 hover:bg-green-700' : 'text-gray-400 bg-gray-100 cursor-not-allowed' }} transition-colors" {!! $app->can_approve ? '' : 'disabled onclick="return false;"' !!} title="{{ $app->can_approve ? 'Approve' : 'Insufficient leave credits (Remaining: '.$app->remaining.')' }}" {!! $app->can_approve ? 'onclick="return confirm(\'Are you sure you want to approve this application?\')"' : '' !!}>
                                        <i class="fa fa-check mr-1"></i> Approve
                                    </a>
                                    <a href="/leave-applications/reject/{{$app->id}}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors" onclick="return confirm('Are you sure you want to reject this application?')">
                                        <i class="fa fa-times mr-1"></i> Reject
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#leavetable').DataTable({
            order: [[0, 'desc']],
            dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"<"flex-1"l><"flex-1 text-right"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"<"flex-1"i><"flex-1 text-right"p>>',
        });
    } );
</script>
