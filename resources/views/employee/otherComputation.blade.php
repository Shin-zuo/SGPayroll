@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div class="panel panel-default" style="background-color:#f7e8f0">
            <div class="panel-heading" style="background-color:#f1c6de"><h1 class="text-center"><strong>Record from previous Employer</strong></h1></div>
            <div class="panel-body">
                <hr class="legend-hr">

                    <div class="col-md-5">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-5 control-label">Total GrossPay</label>
                                <div class="col-sm-4">
                                    <input type="number" class="input-sm form-control" id="otherInputOT_amount" name="otherInputOT_amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-5 control-label">Total SSS Deduction</label>

                                <div class="col-sm-4">
                                    <input type="number" class="input-sm form-control" id="otherInputND_amount" name="otherInputND_amount" placeholder="Amount" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-5 control-label">Total Philhealth Deduction</label>

                                <div class="col-sm-4">
                                    <input type="number" class="input-sm form-control" id="otherInputOtNd_amount" name="otherInputOtNd_amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-5 control-label">Total PAG-IBIG Deduction</label>
                                <div class="col-sm-4">
                                    <input type="number" class="input-sm form-control" id="otherInputOtNd_amount" name="otherInputOtNd_amount" placeholder="Amount">
                                </div>
                            </div>
                        </form>
                        <div class="col-md-3">
                            <button type="button" id="updateData" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save</button>
                        </div>
                    </div>


        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/employee/OvertimeComputation.js"></script>

