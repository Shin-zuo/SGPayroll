@extends('layouts.app')
@section('content')
  
<div class="panel panel-default">
    <div class="panel-heading">Salary</div>
    <div class="panel-body">
        <div class="col-md-8">
            <form class="form-horizontal" action="/salary">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="search">Search by Name :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="search" placeholder="Dela Cruz, Juan" name="search">
                    </div>
                </div>
            </form>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Basic</th>
                <th>Overtime</th>
                <th>Cash Advance</th>
                <th>Others</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employee_salary as $employee_salaries)
                <tr>
                    <td><strong>{{$employee_salaries->full_name}}</strong></td>
                    <td>{{$employee_salaries->basic_pay}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td><strong>-</strong></td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
 
@endsection