@extends('layouts.app')
@section('content')

                <div class="panel panel-default">
                    <div class="panel-heading">SSS</div>
                    <div class="panel-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Salary From</th>
                                <th>Salary To</th>
                                <th>SSS ER</th>
                                <th>EC ER</th>
                                <th>SSS EE</th>
                                <th>Total Contribution</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sss_table as $sss_tables)
                                <tr>
                                    <td><strong>{{$sss_tables->range_from}}</strong></td>
                                    <td><strong>{{$sss_tables->range_to}}</strong></td>
                                    <td>{{$sss_tables->sss_er}}</td>
                                    <td>{{$sss_tables->ec_er}}</td>
                                    <td>{{$sss_tables->sss_ee}}</td>
                                    <td>{{$sss_tables->total}}</td>
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