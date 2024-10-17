@extends('layouts.app')
@section('content')

    <div class="panel panel-default" style="background-color:#f7e8f0">
        <div class="panel-heading text-center" style="background-color:#f1c6de"><h1><strong>Quick Payroll</strong></h1></div>
        <div class="panel-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addDepartmentModal" title="View" data-content="" >
                <span class="glyphicon glyphicon-plus"></span>
                Add Group
            </button>
            <div class="container">
                @if($message = Session::get('success'))
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Success!</strong> {{ $message }}
                    </div>
                @endif
                {!! Session::forget('success') !!}
                <br />
                <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('/quick-payroll/importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="import_file" />
                    <button class="btn btn-primary">Import File</button>
                </form>
            </div>


        </div>

    </div>



@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
