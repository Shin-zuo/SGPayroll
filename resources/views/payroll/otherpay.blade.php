@foreach($employee as $employees)
    <div class="panel panel-default">
        <div class="panel-heading">
            Other Pay
        </div>
        <div class="panel-body payroll-label">
            <div class="col-md-12">
                <div class="col-md-12">
                    
                    <p class="text-muted"><strong> <small> REGULAR</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Representation</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="representation" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Transportation</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="transportation" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">COLA</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="cola" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">FHA</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="fha" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Others</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="others" disabled>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted"><strong> <small> SUPPLEMENTARY</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Commission</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="commission" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Pro. Sharing</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="pro_sharing" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Hazard Pay</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="hazard_pay" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Fees</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="fees" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">13th Month Pay</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="13_month_pay" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Others</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="supplementary_other" disabled>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted"><strong> <small> NON-TAXABLE OTHER PAY</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">13th Month Pay</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="NT13_month_pay">
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 control-label">Other NT Pay</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" id="NTother_pay">
                            </div>
                        </div>
                    </form>

                    <hr>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-7 control-label">Total Other Pay</label>
                            
                            
                            <div class="col-md-5">
                                <input type="text"  class="form-control"  id="other_totalAmount" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
    @endforeach

