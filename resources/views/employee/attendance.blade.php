@extends('layouts.app')
@section('content')
    
    <div class="panel panel-default">
        <div class="panel-heading">Attendance</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>DATE</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th>DURATION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($time_sheet as $time_sheets)
                    <tr>
                        <td>{{$time_sheets->date_log}}</td>
                        <td>{{$time_sheets->time_in}}</td>
                        <td>{{$time_sheets->time_out}}</td>
                        <td><strong>{{$time_sheets->duration}}</strong></td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>
  
@endsection

