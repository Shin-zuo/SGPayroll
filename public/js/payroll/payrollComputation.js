$(document).ready(function () {
    $('[name="13Month"]').change(function() {
        alertify.confirm("Are you sure that you want to enable the Thirteen Month computation?",
        function(){
            $("#13Month").prop('checked', true);
            alertify.success('Ok');
        },
        function(){
            $("#13Month").prop('checked', false);
            alertify.error('Cancel');
        });
    });
 
    var lastPayrollNo = {
        deptCode: $('#deptCode').val(),
    };
    var type = "GET";
    var checkPayrollNo = '/payroll/{department}/checkPayrollNo';
    $.ajax({
        type: type,
        url: checkPayrollNo,
        data: lastPayrollNo,
        dataType: 'json',
        success: function (data) {

            if (data.endMonth == "false")
            {
                $('select[name="payroll_no"]').val(parseInt(data.payrollNo)+1);
                if($('#payroll_no').val()==2 && data.payroll_type == 1 || $('#payroll_no').val()== 2 && data.payroll_type == 2)
                {
                    $('#endMonth').prop('checked', true);
                }
            }
            else
            {
                $('select[name="payroll_no"] option:first').val();
            }

        },
        error: function (data) {
        }
    });
    if($('#employeePayroll_type').val()==1 || $('#employeePayroll_type').val()==2)
    {
        $('#payroll_no').change(function() {
            // Check input( $( this ).val() ) for validity here
            if($('#payroll_no').val()==2)
            {
                $('#endMonth').prop('checked', true);
            }
            else
            {
                $('#endMonth').prop('checked', false);
            }
        });
    }
    $('#insertFinishData').on('click',function () {

        alertify.confirm("Confirm","Are you sure want to insert this data?",
            function(){
                var selector = $('.payroll-table-main');
                var formData = selector;
                $(formData).each(function (index,value) {
                    var arrayData= {
                        employee_id: $(this).find('input[name=employee]').val(),
                        work_days: $(this).find('input[name=work_days]').val(),
                        basic_pay: $(this).find('input[name=basic_amount]').val(),
                        word_days_amount: $(this).find('input[name=work_days_amount]').val(),
                        overtime_hours: $(this).find('input[name=overtime_hours]').val(),
                        over_time_amount: $(this).find('input[name=over_time_amount]').val(),
                        extra_regular_hour: $(this).find('input[name=extra_regular_hour]').val(),
                        extra_regular_hours_amount: $(this).find('input[name=extra_regular_hours_amount]').val(),
                        night_diff: $(this).find('input[name=night_diff]').val(),
                        night_diff_amount: $(this).find('input[name=night_diff_amount]').val(),
                        //HOLIDAY
                        rest_special:  $(this).find('input[name=rest_special]').val(),
                        rest_special_amount:  $(this).find('input[name=rest_special_amount]').val(),
                        rest_special_exc: $(this).find('input[name=rest_special_exc]').val(),
                        rest_special_exc_amount: $(this).find('input[name=rest_special_exc_amount]').val(),
                        regular_holiday_hour:  $(this).find('input[name=regular_holiday_hour]').val(),
                        regular_holiday_hour_amount:  $(this).find('input[name=regular_holiday_hour_amount]').val(),
                        regular_holiday_hour_exc:  $(this).find('input[name=regular_holiday_hour_exc]').val(),
                        regular_holiday_hour_exc_amount:  $(this).find('input[name=regular_holiday_hour_exc_amount]').val(),
                        restday_on_regular: $(this).find('input[name=restday_on_regular]').val(),
                        restday_on_regular_amount: $(this).find('input[name=restday_on_regular_amount]').val(),
                        restday_on_regular_exc: $(this).find('input[name=restday_on_regular_exc]').val(),
                        restday_on_special: $(this).find('input[name=restday_on_special]').val(),
                        restday_on_special_exc: $(this).find('input[name=restday_on_special_exc]').val(),
                        //DEBIT HOLIDAY
                        regular_holiday: $(this).find('input[name=regular_holiday]').val(),
                        regular_holiday_amount: $(this).find('input[name=regular_holiday_amount]').val(),
                        special_holiday: $(this).find('input[name=special_holiday]').val(),
                        special_holiday_amount: $(this).find('input[name=special_holiday_amount]').val(),
                        regular_holiday_minimum: $(this).find('input[name=regular_holiday_minimum]').val(),
                        regular_holiday_minimum_amount: $(this).find('input[name=regular_holiday_minimum_amount]').val(),
                        special_holiday_minimum: $(this).find('input[name=special_holiday_minimum]').val(),
                        special_holiday_minimum_amount: $(this).find('input[name=special_holiday_minimum_amount]').val(),
                        //LEAVE
                        sick_leave: $(this).find('input[name=sick_leave]').val(),
                        sick_leave_amount: $(this).find('input[name=sick_leave_amount]').val(),
                        vacation_leave: $(this).find('input[name=vacation_leave]').val(),
                        vacation_leave_amount: $(this).find('input[name=vacation_leave_amount]').val(),
                        //OTHER PAY
                        thirteen_month: $(this).find('input[name=thirteen_month]').val(),
                        cola: $(this).find('input[name=cola]').val(),
                        nt_pay: $(this).find('input[name=nt_pay]').val(),
                        //GROSSPAY
                        total_gross:  $(this).find('input[name=gross_pay]').val(),
                        //DEDUCTION
                        sss:$(this).find('[name=sss_deduction]').text(),
                        provident_fund:$(this).find('[name=sss_provident_fund]').text(),
                        phil_health:$(this).find('[name=phil_deduction]').text(),
                        pag_ibig:$(this).find('[name=pagibig_deduction]').text(),
                        witholding:$(this).find('[name=witholding_tax]').text(),
                        insurance:$(this).find('[name=insurance]').text(),
                        //LOANS
                        sss_loan: $(this).find('[name=sss_loan]').text(),
                        sss_calamity_loan :  $(this).find('[name=calamity_loan]').text(),
                        pagibig_loan: $(this).find('[name=hdmf_loan]').text(),
                        company_loan: $(this).find('[name=company_loan]').text(),
                        other_loan: $(this).find('[name=other_loan]').text(),
                        rent: $(this).find('[name=rent_other]').text(),
                        net_pay:$(this).find('[name=net_pay]').text(),
                        //DATE
                        date_from: $('#date_from').val(),
                        date_to: $('#date_to').val(),
                        //PAYROLL NUMBER
                        payroll_no: $('#payroll_no').val(),
                        //DEPARTMENT
                        department: $('#deptName').val(),
                        //END MONTH
                        endMonth: $('#endMonth').prop('checked'),
                    };
                    $.ajax({
                        type: "GET",
                        url: '/payroll/{department}/insetFinishData',
                        data:arrayData ,
                        dataType: 'json',
                        success: function (data) {
                           // $('#insertFinishData').hide();
                           //  alertify.success(data.employee + " " + 'Data Save!');
                        }
                    });
                });
            },
            function(){
                alertify.error('Cancel');
            });


    });
});
$(document).ready(function () {
    $('.payroll-table-main').on('keyup', function (e) {
        if (e.keyCode == 13) {
                var formData = {
                    //BASIC PAY
                    department:  $('#deptCode').val(),
                    payroll_no: $('#payroll_no').val(),
                    employee_id: $(e.currentTarget).find('input[name=employee]').val(),
                    work_days: $(e.currentTarget).find('input[name=work_days]').val(),
                    overtime_hours: $(e.currentTarget).find('input[name=overtime_hours]').val(),
                    overtime_hours_amount: $(e.currentTarget).find('input[name=over_time_amount]').val(),
                    extra_regular_hour: $(e.currentTarget).find('input[name=extra_regular_hour]').val(),
                    extra_regular_hour_amount: $(e.currentTarget).find('input[name=extra_regular_hours_amount]').val(),
                    night_diff: $(e.currentTarget).find('input[name=night_diff]').val(),
                    //HOLIDAY
                    rest_special:  $(e.currentTarget).find('input[name=rest_special]').val(),
                    rest_special_exc: $(e.currentTarget).find('input[name=rest_special_exc]').val(),
                    regular_holiday_hour:  $(e.currentTarget).find('input[name=regular_holiday_hour]').val(),
                    regular_holiday_hour_exc:  $(e.currentTarget).find('input[name=regular_holiday_hour_exc]').val(),
                    restday_on_regular: $(e.currentTarget).find('input[name=restday_on_regular]').val(),
                    restday_on_regular_exc: $(e.currentTarget).find('input[name=restday_on_regular_exc]').val(),
                    restday_on_special: $(e.currentTarget).find('input[name=restday_on_special]').val(),
                    restday_on_special_exc: $(e.currentTarget).find('input[name=restday_on_special_exc]').val(),
                    //DEBIT HOLIDAY
                    regular_holiday: $(e.currentTarget).find('input[name=regular_holiday]').val(),
                    special_holiday: $(e.currentTarget).find('input[name=special_holiday]').val(),
                    regular_holiday_minimum: $(e.currentTarget).find('input[name=regular_holiday_minimum]').val(),
                    special_holiday_minimum: $(e.currentTarget).find('input[name=special_holiday_minimum]').val(),
                    //LEAVE
                    sick_leave: $(e.currentTarget).find('input[name=sick_leave]').val(),
                    vacation_leave: $(e.currentTarget).find('input[name=vacation_leave]').val(),
                    leave_pay: $(e.currentTarget).find('input[name=leave_pay]').val(),
                    //CREDIT
                    absent: $(e.currentTarget).find('input[name=absent]').val(),
                    underTime: $(e.currentTarget).find('input[name=underTime]').val(),
                    //OTHER PAY
                    other_pay: $(e.currentTarget).find('input[name=other_pay]').val(),
                    thirteen_month: $(e.currentTarget).find('input[name=thirteen_month]').val(),
                    transportation: $('#transportation').val(),
                    cola: $(e.currentTarget).find('input[name=cola]').val(),
                    nt_pay: $(e.currentTarget).find('input[name=nt_pay]').val(),
                    fha: $('#fha').val(),
                    regular_other: $('#others').val(),
                    commission: $('#commission').val(),
                    pro_sharing: $('#pro_sharing').val(),
                    hazard_pay: $('#hazard_pay').val(),
                    fees: $('#fees').val(),
                    supplementary_other: $('#supplementary_other').val(),
                    //END OF MONTH
                    date_from: $('#date_from').val(),
                    date_to: $('#date_to').val(),
                    endMonth: $('#endMonth').prop('checked'),
                    thirteenMonth: $('#13Month').prop('checked'),
                };
                $.ajax({
                type: "GET",
                url: "/payroll/{department}/BasicComputation",
                data: formData,
                dataType: 'json',
                success: function (data) {
                    //BASIC PAY
                    console.log(data);
                    $(e.currentTarget).find('input[name=basic_amount]').val(data.basic_pay);
                    $(e.currentTarget).find('input[name=work_days_amount]').val(data.work_days_amount);
                    $(e.currentTarget).find('input[name=over_time_amount]').val(data.over_time_amount);
                    $(e.currentTarget).find('input[name=extra_regular_hours_amount]').val(data.extra_regular_hours_amount);
                    $(e.currentTarget).find('input[name=night_diff_amount]').val(data.night_diff_amount);
                    $(e.currentTarget).find('input[name=excess_amount]').val(data.extra_regular_hours_amount);
                    //HOLIDAY
                    $(e.currentTarget).find('input[name=rest_special_amount]').val(data.rest_special_amount);
                    $(e.currentTarget).find('input[name=rest_special_exc_amount]').val(data.rest_special_exc_amount);
                    $(e.currentTarget).find('input[name=regular_holiday_hour_amount]').val(data.regular_holiday_hour_amount);
                    $(e.currentTarget).find('input[name=regular_holiday_hour_exc_amount]').val(data.regular_holiday_hour_exc_amount);
                    $(e.currentTarget).find('input[name=restday_on_regular_amount]').val(data.restday_on_regular_amount);
                    $(e.currentTarget).find('input[name=gross_pay]').val(data.total_grosspay);
                    $(e.currentTarget).find('input[name=ot_pay_total]').val(data.ot_pay_total);
                    //OTHER PAY
                    $(e.currentTarget).find('input[name=cola]').val(data.cola);
                    $(e.currentTarget).find('input[name=nt_pay]').val(data.Ntother_pay);
                    $('#other_totalAmount').val(data.other_totalAmount);
                    //13MONTH
                    $(e.currentTarget).find('input[name=thirteen_month]').val(data.thirteenMonth);
                    //DEDUCTION
                    $(e.currentTarget).find('[name=witholding_tax]').text(data.witholding_tax);
                    $(e.currentTarget).find('[name=sss_deduction]').text(data.sss_deduction);
                    $(e.currentTarget).find('[name=sss_provident_fund]').text(data.provident_fund);
                    $(e.currentTarget).find('[name=phil_deduction]').text(data.phil_deduction);
                    $(e.currentTarget).find('[name=pagibig_deduction]').text(data.pagibig_deduction);
                    $(e.currentTarget).find('[name=insurance]').text(data.insurance);
                    $(e.currentTarget).find('[name=net_pay]').text(data.net_pay);
                    $(e.currentTarget).find('input[name=leave_pay_total]').val(data.leave_pay_total);
                    //LOAN
                    $(e.currentTarget).find('[name=sss_loan]').text(data.sss_loan_deduction);
                    $(e.currentTarget).find('[name=hdmf_loan]').text(data.pagibig_loan_deduction);
                    $(e.currentTarget).find('[name=company_loan]').text(data.company_loan_deduction);
                    $(e.currentTarget).find('[name=other_loan]').text(data.other_loan);
                    $(e.currentTarget).find('[name=calamity_loan]').text(data.sss_calamity_loan);
                    $(e.currentTarget).find('[name=rent_other]').text(data.rent);
                    //DEBIT
                    $(e.currentTarget).find('[name=regular_holiday_amount]').val(data.regular_holiday);
                    $(e.currentTarget).find('[name=special_holiday_amount]').val(data.special_holiday);
                    $(e.currentTarget).find('[name=regular_holiday_minimum_amount]').val(data.regular_holiday_minimum);
                    $(e.currentTarget).find('[name=special_holiday_minimum_amount]').val(data.special_holiday_minimum);
                    //LEAVE
                    $(e.currentTarget).find('[name=vacation_leave_amount]').val(data.vacation_leave);
                    $(e.currentTarget).find('[name=sick_leave_amount]').val(data.sick_leave);
                }
            });
        }
    });
});
