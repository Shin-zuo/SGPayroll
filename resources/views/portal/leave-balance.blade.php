@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#192965] flex items-center gap-2">
            <i class="fa fa-calendar-alt"></i> Leave Applications &amp; Balances
        </h2>
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

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Leave Balances -->
        <div class="md:col-span-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-4">
                <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                    <h4 class="text-lg font-semibold text-gray-800 m-0 flex items-center gap-2">
                        <i class="fa fa-chart-pie text-blue-500"></i> Your Balances for {{ $year }}
                    </h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Leave Type</th>
                                <th class="px-6 py-4 font-semibold text-center">Limit</th>
                                <th class="px-6 py-4 font-semibold text-center">Used</th>
                                <th class="px-6 py-4 font-semibold text-center">Remaining</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">Vacation Leave</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $vacation ? $vacation->credit_limit : 0 }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $vacation ? $vacation->used_days : 0 }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">
                                        {{ $vacation_remaining }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">Sick Leave</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $sick ? $sick->credit_limit : 0 }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $sick ? $sick->used_days : 0 }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full">
                                        {{ $sick_remaining }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="/portal" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors bg-white border border-gray-300 rounded-full px-4 py-2 hover:bg-gray-50">
                &larr; Back to Dashboard
            </a>
        </div>

        <!-- Apply Form -->
        <div class="md:col-span-7">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                    <h4 class="text-lg font-semibold text-gray-800 m-0">File a Leave Application</h4>
                </div>
                <div class="p-6">
                    <form action="/portal/leave-apply" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                            <select name="leave_type" id="leave_type" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="" disabled selected>Select Leave Type...</option>
                                <option value="vacation">Vacation Leave</option>
                                <option value="sick">Sick Leave</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date" id="date_from" name="date_from" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date" id="date_to" name="date_to" class="form-control w-full border border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                            <textarea id="reason" name="reason" class="form-control w-full border border-gray-300 rounded-md p-3 focus:border-blue-500 focus:ring focus:ring-blue-200" rows="3" placeholder="Please provide a brief reason for your leave..." required></textarea>
                        </div>
                        <button type="submit" id="submitLeaveBtn" class="w-full bg-[#192965] hover:bg-blue-800 text-white font-medium py-2 px-6 rounded-md transition-colors flex items-center justify-center gap-2">
                            <i class="fa fa-paper-plane"></i> Submit Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Application History -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                <h4 class="text-lg font-semibold text-gray-800 m-0 flex items-center gap-2">
                    <i class="fa fa-history"></i> My Leave History
                </h4>
            </div>
            <div class="p-6 overflow-x-auto">
                @if($applications->isEmpty())
                    <div class="text-center py-12 px-4">
                        <i class="fa fa-inbox text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No leave applications found. Apply for your first leave above!</p>
                    </div>
                @else
                    <table id="leaveHistoryTable" class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold">#</th>
                                <th class="px-4 py-3 font-semibold">Type</th>
                                <th class="px-4 py-3 font-semibold">Date From</th>
                                <th class="px-4 py-3 font-semibold">Date To</th>
                                <th class="px-4 py-3 font-semibold text-center">Days</th>
                                <th class="px-4 py-3 font-semibold">Reason</th>
                                <th class="px-4 py-3 font-semibold text-center">Status</th>
                                <th class="px-4 py-3 font-semibold">Remarks</th>
                                <th class="px-4 py-3 font-semibold">Applied On</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($applications as $app)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-600">{{ $app->id }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ ucfirst($app->leave_type) }} Leave</td>
                                <td class="px-4 py-3 text-gray-600">{{ $app->date_from }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $app->date_to }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $app->total_days }}</td>
                                <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $app->reason }}">{{ $app->reason }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($app->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($app->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                    @elseif($app->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($app->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $app->admin_remarks ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($app->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if(!$applications->isEmpty())
        $('#leaveHistoryTable').DataTable({
            order: [[8, 'desc']],
            pageLength: 10,
            dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"<"flex-1"l><"flex-1 text-right"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"<"flex-1"i><"flex-1 text-right"p>>',
        });
        @endif
    });
</script>
@endsection

