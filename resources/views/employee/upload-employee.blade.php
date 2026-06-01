@extends('layouts.app')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Upload Employees</h1>
    <nav class="text-sm font-medium text-slate-500" aria-label="Breadcrumb">
        <ol class="flex space-x-2">
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('employee') }}" class="hover:text-slate-800 transition-colors">Employees</a></li>
            <li><span>/</span></li>
            <li class="text-slate-800">Upload</li>
        </ol>
    </nav>
</div>

<div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden mb-6 max-w-xl mx-auto">
    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-base font-semibold text-slate-800">Import Employee Directory</h2>
        <a href="{{ route('employee') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fa fa-arrow-left mr-1.5"></i> Back
        </a>
    </div>
    
    <div class="p-6">
        @if($message = Session::get('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm mb-4 relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif
        {!! Session::forget('success') !!}

        <p class="text-xs text-slate-500 mb-4">
            Upload an Excel (.xls, .xlsx) file containing employee records to batch import them into the system. Ensure all columns match the required template.
        </p>

        <form action="{{ URL::to('/uploadFile-employee/importEmployeeExcel') }}" class="space-y-4" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="border-2 border-dashed border-slate-200 hover:border-slate-300 rounded-lg p-6 flex flex-col items-center justify-center bg-slate-50 transition-colors cursor-pointer relative">
                <i class="fa fa-file-excel text-3xl text-slate-400 mb-2"></i>
                <span class="text-sm font-medium text-slate-600 mb-1">Select Excel File</span>
                <span class="text-xs text-slate-400">Drag & drop or click to choose file</span>
                <input type="file" name="import_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
            </div>
            
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto">
                    Import File
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>