
    <div class="panel panel-default">
        <div class="panel-heading">
            Basic Pay
        </div>
        <div class="panel-body payroll-label">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-5">
                        
                    </div>
                    <div class="col-md-3"><p>Days/Hrs</p></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3"><p>Amount</p></div>
                    </div>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Work Days</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="work_days">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="work_days_amount"  disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Overtime</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="over_time">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="overtime_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Ext. Reg Hrs</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Night Diff</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="night_dif">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="nightdif_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Rest/Special</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="rest_day">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="restday_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Rest/Special (excess hours)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="restday_excess">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">EHrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="restday_excess_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Regular Holiday</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="regular_holiday">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="regular_holiday_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Regular Holiday (excess hours)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="regular_excess">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">EHrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="regular_excess_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Rest/Holiday</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="rest_holiday">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">EHrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="rest_holiday_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Rest/Holiday (excess hours)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="rest_holiday_excess">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">EHrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="rest_holiday_excess_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted"><strong> <small> DEBIT</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Absent(Days)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="absent">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="absent_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Undertime(Hrs)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="under_time">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Hrs</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="undertime_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted"><strong> <small> CREDIT</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">Reg Hol(Days)</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="number_of_holiday">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="number_holiday_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted"><strong> <small> NON-TAXABLE BENEFITS</small></strong></p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">SIL</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="service_incentive_leave">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="service_incentive_leave_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">VL</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="vacation_leave">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="vacation_leave_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">SL</label>
                            <div class="col-md-3">
                                <input type="number"  class="form-control" id="sick_leave">
                            </div>
                            <div class="col-md-1">
                                <p class="control-label">Day(s)</p>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  class="form-control" id="sick_leave_amount" disabled>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-7 control-label">Total Basic Pay</label>
                            
                            
                            <div class="col-md-5">
                                <input type="text"  class="form-control"  id="totalAmount" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
    

