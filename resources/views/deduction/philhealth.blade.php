@extends('layouts.app')
@section('content')
    
                <div class="panel panel-default">
                    <div class="panel-heading">PhilHealth</div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Salary Range From</th>
                                <th>Salary Range To</th>
                                <th>Monthly Premium</th>
                                <th>Employer & Employee Share</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($phil_table as $phil_tables)
                            <tr>
                                <td><strong>{{$phil_tables->range_from}}</strong></td>
                                <td><strong>{{$phil_tables->range_to}}</strong></td>
                                <td>{{$phil_tables->monthy_premium}}</td>
                                <td>{{$phil_tables->personal_share}}</td>
                                <td>{{$phil_tables->employer_share}}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
       
@endsection