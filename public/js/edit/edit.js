$(document).ready(function() {
    var url_subgroup = "/edit/requestEmployee";
    var url_employeeData = "/edit/requestEmployeeData";
    $('#department').on('change', function() {
        var formData = {
            group_code: $('#department').val(),
        };
        var type = "GET";
        var url_subgroups = url_subgroup;
        $.ajax({
            type: type,
            url: url_subgroups,
            data: formData,
            dataType: 'json',
            success: function (data) {
                var appendData = '';
                $.each(data, function (index, employee) {
                    appendData += '<option value="'+ employee.id+'">'+employee.employee_id+' '+"-"+'  '+employee.employee_Lname+''+","+' '+employee.employee_Fname+'</option>'
                })
                $('#employee').html(appendData)
                var formDataemployee = {
                    employee_code: $('#employee').val(),
                };
                var typeEdit = "GET";
                var url_employeeDatas = url_employeeData;
                $.ajax({
                    type: typeEdit,
                    url: url_employeeDatas,
                    data: formDataemployee,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $('#payroll_id').val(data.id);
                        $('#employee_id').val(data.employee_code);
                        $('#inputGP_amount').val(data.gross_pay);
                        $('#inputWD').val(data.work_days);
                        $('#inputWD_amount').val(data.work_days_amount);
                        $('#inputOT').val(data.overtime);
                        $('#inputOT_amount').val(data.overtime_amount);
                        $('#inputER').val(data.ext_reg_hrs);
                        $('#inputER_amount').val(data.ext_reg_hrs_ammount);
                        $('#inputND').val(data.night_diff);
                        $('#inputND_amount').val(data.night_diff_amount);
                        $('#inputRS').val(data.rest_special);
                        $('#inputRS_amount').val(data.rest_special_amount);
                        $('#inputERS').val(data.exc_rest_special);
                        $('#inputERS_amount').val(data.exc_rest_special_amount);
                        $('#inputRH').val(data.regular_holiday);
                        $('#inputRH_amount').val(data.regular_holiday_amount);
                        $('#inputERH').val(data.exc_regular_holiday);
                        $('#inputERH_amount').val(data.exc_regular_holiday_amount);
                        $('#inputRDR').val(data.rest_on_regular);
                        $('#inputRDR_amount').val(data.rest_on_regular_amount);
                        $('#inputERDR').val(data.exc_rest_on_regular);
                        $('#inputERDR_amount').val(data.exc_rest_on_regular_amount);
                        $('#inputRDS').val(data.rest_on_special);
                        $('#inputRDS_amount').val(data.rest_on_special_amount);
                        $('#inputERDS').val(data.exc_rest_on_special);
                        $('#inputERDS_amount').val(data.exc_rest_on_special_amount);
                        $('#inputAbsent').val(data.absent);
                        $('#inputAbsent_amount').val(data.absent_amount);
                        $('#inputCRH').val(data.regular_holiday_day);
                        $('#inputCRH_amount').val(data.regular_holiday_day_amount);
                        $('#inputCSH').val(data.special_holiday_day);
                        $('#inputCSH_amount').val(data.special_holiday_day_amount);
                        //LEAVE
                        $('#inputIL').val(data.sick_leave);
                        $('#inputIL_amount').val(data.sick_leave_amount);
                        $('#inputSL').val(data.vacation_leave);
                        $('#inputSL_amount').val(data.vacation_leave_amount);
                        //Non-Tax
                        $('#inputNTP_amount').val(data.non_tax_other);
                        $('#inputCola_amount').val(data.cola_amount);
                        //Contribution
                        $('#inputWT_amount').val(data.witholding_tax);
                        $('#inputSSS_contrib').val(data.sss_contribution);
                        $('#inputPHIC_contrib').val(data.phic_contribution);
                        $('#inputHDMF_contrib').val(data.hdmf_contribution);
                        $('#inputInsurance').val(data.insurance);
                        //LOANS
                        $('#inputSSS_loan').val(data.sss_loan);
                        $('#inputHDMF_loan').val(data.hdmf_loan);
                        $('#inputCoop_loan').val(data.other_loan);
                        $('#inputOther_loan').val(data.rent);
                        //NET PAY
                        $('#inputNP_amount').val(data.net_pay);
                        //DATE
                        $('#date_from').val(data.date_from);
                        $('#date_to').val(data.date_to);
                        $('#endMonth').val(data.endMonth);
                        $('#payroll_no').val(data.payroll_number);

                    },
                    error: function (data) {
                        alertify.error('No Record Found !');
                        // console.log(data);
                    }

                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });
    ///////////////////////////////////////////////
    $('#employee').on('change', function() {
        var formData = {
            employee_code: $('#employee').val(),
        };
        var type = "GET";
        var url_employeeDatas = url_employeeData;
        $.ajax({
            type: type,
            url: url_employeeDatas,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#payroll_id').val(data.id);
                $('#employee_id').val(data.employee_code);
                $('#inputGP_amount').val(data.gross_pay);
                $('#inputWD').val(data.work_days);
                $('#inputWD_amount').val(data.work_days_amount);
                $('#inputOT').val(data.overtime);
                $('#inputOT_amount').val(data.overtime_amount);
                $('#inputER').val(data.ext_reg_hrs);
                $('#inputER_amount').val(data.ext_reg_hrs_ammount);
                $('#inputND').val(data.night_diff);
                $('#inputND_amount').val(data.night_diff_amount);
                $('#inputRS').val(data.rest_special);
                $('#inputRS_amount').val(data.rest_special_amount);
                $('#inputERS').val(data.exc_rest_special);
                $('#inputERS_amount').val(data.exc_rest_special_amount);
                $('#inputRH').val(data.regular_holiday);
                $('#inputRH_amount').val(data.regular_holiday_amount);
                $('#inputERH').val(data.exc_regular_holiday);
                $('#inputERH_amount').val(data.exc_regular_holiday_amount);
                $('#inputRDR').val(data.rest_on_regular);
                $('#inputRDR_amount').val(data.rest_on_regular_amount);
                $('#inputERDR').val(data.exc_rest_on_regular);
                $('#inputERDR_amount').val(data.exc_rest_on_regular_amount);
                $('#inputRDS').val(data.rest_on_special);
                $('#inputRDS_amount').val(data.rest_on_special_amount);
                $('#inputERDS').val(data.exc_rest_on_special);
                $('#inputERDS_amount').val(data.exc_rest_on_special_amount);
                $('#inputAbsent').val(data.absent);
                $('#inputAbsent_amount').val(data.absent_amount);
                $('#inputCRH').val(data.regular_holiday_day);
                $('#inputCRH_amount').val(data.regular_holiday_day_amount);
                $('#inputCSH').val(data.special_holiday_day);
                $('#inputCSH_amount').val(data.special_holiday_day_amount);
                //LEAVE
                $('#inputIL').val(data.sick_leave);
                $('#inputIL_amount').val(data.sick_leave_amount);
                $('#inputSL').val(data.vacation_leave);
                $('#inputSL_amount').val(data.vacation_leave_amount);
                //Non-Tax
                $('#inputNTP_amount').val(data.non_tax_other);
                $('#inputCola_amount').val(data.cola_amount);
                //Contribution
                $('#inputWT_amount').val(data.witholding_tax);
                $('#inputSSS_contrib').val(data.sss_contribution);
                $('#inputPHIC_contrib').val(data.phic_contribution);
                $('#inputHDMF_contrib').val(data.hdmf_contribution);
                $('#inputInsurance').val(data.insurance);
                //LOANS
                $('#inputSSS_loan').val(data.sss_loan);
                $('#inputHDMF_loan').val(data.hdmf_loan);
                $('#inputCoop_loan').val(data.other_loan);
                $('#inputOther_loan').val(data.rent);
                //NET PAY
                $('#inputNP_amount').val(data.net_pay);
                //DATE
                $('#date_from').val(data.date_from);
                $('#date_to').val(data.date_to);
                $('#endMonth').val(data.endMonth);
                $('#payroll_no').val(data.payroll_number);
            },
            error: function (data) {
                alertify.error('No Record Found !');
                // console.log(data);
            }

        });
    });
    $( "#Recompute" ).click(function(e) {
        var reComputeData = {
            employee_id: $('#employee_id').val(),
            work_days: $('#inputWD').val(),
            overtime_hours: $('#inputOT').val(),
            extra_regular_hour: $('#inputER').val(),
            night_diff: $('#inputND').val(),
            rest_special: $('#inputRS').val(),
            rest_special_exc: $('#inputERS').val(),
            regular_holiday_hour: $('#inputRH').val(),
            regular_holiday_hour_exc: $('#inputERH').val(),
            restday_on_regular: $('#inputRDR').val(),
            restday_on_regular_exc: $('#inputERDR').val(),
            restday_on_special: $('#inputRDS').val(),
            restday_on_special_exc: $('#inputERDS').val(),
            regular_holiday: $('#inputCRH').val(),
            special_holiday: $('#inputCSH').val(),
            other_pay: $('#inputOther_amount').val(),
            sick_leave: $('#inputIL').val(),
            vacation_leave: $('#inputSL').val(),
            date_from: $('#date_from').val(),
            date_to: $('#date_to').val(),
            endMonth: $('#endMonth').val(),
            payroll_no : $('#payroll_no').val()
        };
        $.ajax({
            type: "GET",
            url: "/payroll/{department}/BasicComputation",
            data: reComputeData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#inputWD_amount').val(data.basic_pay);
                $('#inputOT_amount').val(data.over_time_amount);
                $('#inputER_amount').val(data.extra_regular_hours_amount);
                $('#inputND_amount').val(data.night_diff_amount);
                $('#inputRS_amount').val(data.rest_special_amount);
                $('#inputERS_amount').val(data.rest_special_exc_amount);
                $('#inputRH_amount').val(data.regular_holiday_hour_amount);
                $('#inputERH_amount').val(data.regular_holiday_hour_exc_amount);
                $('#inputRDR_amount').val(data.restday_on_regular_amount);
                $('#inputERDR_amount').val(data.restday_on_regular_exc_amount);
                $('#inputRDS_amount').val(data.restday_on_special);
                $('#inputERDS_amount').val(data.restday_on_special_exc);
                $('#inputSSS_contrib').val(data.sss_deduction);
                $('#inputPHIC_contrib').val(data.phil_deduction);
                $('#inputHDMF_contrib').val(data.pagibig_deduction);
                $('#inputInsurance').val(data.insurance);
                $('#inputCRH_amount').val(data.regular_holiday);
                $('#inputCSH_amount').val(data.special_holiday);
                $('#inputIL_amount').val(data.sick_leave);
                $('#inputSL_amount').val(data.vacation_leave);
                $('#inputGP_amount').val(data.total_grosspay);
                $('#inputNP_amount').val(data.net_pay);
                $('#inputNTP_amount').val(data.Ntother_pay);
            }
        });
    });
    $('#updateData').click(function (e) {
        alertify.confirm("Do you want to save this data? ",
            function(){
                var updateData = {
                    payroll_id: $('#payroll_id').val(),
                    employee_id: $('#employee_id').val(),
                    work_days: $('#inputWD').val(),
                    work_days_amount: $('#inputWD_amount').val(),
                    overtime_hours: $('#inputOT').val(),
                    overtime_hours_amount: $('#inputOT_amount').val(),
                    extra_regular_hour: $('#inputER').val(),
                    extra_regular_hour_amount: $('#inputER_amount').val(),
                    night_diff: $('#inputND').val(),
                    night_diff_amount: $('#inputND_amount').val(),
                    rest_special: $('#inputRS').val(),
                    rest_special_amount: $('#inputRS_amount').val(),
                    rest_special_exc: $('#inputERS').val(),
                    rest_special_exc_amount: $('#inputERS_amount').val(),
                    regular_holiday_hour: $('#inputRH').val(),
                    regular_holiday_hour_amount: $('#inputRH_amount').val(),
                    regular_holiday_hour_exc: $('#inputERH').val(),
                    regular_holiday_hour_exc_amount: $('#inputERH_amount').val(),
                    restday_on_regular: $('#inputRDR').val(),
                    restday_on_regular_amount: $('#inputRDR_amount').val(),
                    restday_on_regular_exc: $('#inputERDR').val(),
                    restday_on_regular_exc_amount: $('#inputERDR_amount').val(),
                    restday_on_special: $('#inputRDS').val(),
                    restday_on_special_amount: $('#inputRDS_amount').val(),
                    restday_on_special_exc: $('#inputERDS').val(),
                    restday_on_special_exc_amount: $('#inputERDS_amount').val(),
                    regular_holiday_day: $('#inputCRH').val(),
                    regular_holiday_day_amount: $('#inputCRH_amount').val(),
                    special_holiday: $('#inputCSH').val(),
                    special_holiday_amount: $('#inputCSH_amount').val(),
                    incentive_leave: $('#inputIL').val(),
                    incentive_leave_amount: $('#inputIL_amount').val(),
                    cola_amount: $('#inputCola_amount').val(),
                    non_tax_other: $('#inputNTP_amount').val(),
                    gross_pay: $('#inputGP_amount').val(),
                    wt_amount: $('#inputWT_amount').val(),
                    sss_contribution: $('#inputSSS_contrib').val(),
                    phic_contribution: $('#inputPHIC_contrib').val(),
                    hdmf_contribution: $('#inputHDMF_contrib').val(),
                    insurance: $('#inputInsurance').val(),
                    sss_loan: $('#inputSSS_loan').val(),
                    hdmf_loan: $('#inputHDMF_loan').val(),
                    other_loan: $('#inputCoop_loan').val(),
                    rent: $('#inputOther_loan').val(),
                    net_pay: $('#inputNP_amount').val(),
                    date_from: $('#date_from').val(),
                    date_to: $('#date_to').val(),
                    endMonth: $('#endMonth').val(),
                    payroll_no : $('#payroll_no').val()
                };
                $.ajax({
                    type: "GET",
                    url: "/payroll/payroll-update/{id}",
                    data: updateData,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        alertify.success('Payroll updated successfully!');
                    }
                });

            },
            function(){
                alertify.error('Cancel');
            });
    });

});