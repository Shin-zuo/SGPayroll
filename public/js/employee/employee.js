$(document).ready(function(){
    $(document).on('show.bs.modal','.bd-example-modal-sm', function (e) {
        var link     = $(e.relatedTarget),
            id = link.data("id");
        $('#id').val(id);
        console.log(id);
    });
    var url_delete = "/employee/DeleteEmployeeAccount";
    var turn_active = "/employee/ActiveEmployeeAccount";
    //create new task / update existing task
    $("#btnYes").click(function (e) {
        e.preventDefault();
        var type = "GET"; //for creating new resource
        var delete_data = {
            id : $('#id').val()
        }
        // var delete_url = url_delete;
        $.ajax({
            type: type,
            url: url_delete,
            data: delete_data,
            dataType: 'json',
            success: function (data) {
                $('.bd-example-modal-sm').remove();
                location.reload();
            },

        });
    });
    $("#btnYesActive").click(function (e) {
        e.preventDefault();
        var type = "GET"; //for creating new resource
        var active_data = {
            id : $('#id').val()
        }
        // var delete_url = url_delete;
        $.ajax({
            type: type,
            url: turn_active,
            data: active_data,
            dataType: 'json',
            success: function (data) {
                $('.bd-example-modal-sm').remove();
                location.reload();
            },

        });
    });
    var url_subgroup = "/employee/requestData";
    $('#department').on('change', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })
        var formData = {
            group_id: $('#department').val(),
        }


        var type = "GET";
        var url_subgroups = url_subgroup;
        $.ajax({
            type: type,
            url: url_subgroups,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var appendData = '<option value="" selected disabled>Select Sub Department</option>';
                $.each(data, function (index, dept) {
                    appendData += '<option value="'+ dept.sub_department_name+'">'+dept.sub_department_name+'</option>'
            })

                $('#sub_department').html(appendData)
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });
    window.leaveEditingEnabled = false;

    window.toggleLeaveEditing = function(e) {
        if (e && e.preventDefault) e.preventDefault();
        window.leaveEditingEnabled = !window.leaveEditingEnabled;
        if (window.leaveEditingEnabled) {
            $('#leave, #sick')
                .prop('readonly', false)
                .removeAttr('readonly')
                .removeClass('bg-slate-100 text-slate-500 cursor-not-allowed')
                .addClass('bg-white text-slate-800 border-blue-500 ring-1 ring-blue-500');
            $('#leave_lock_icon').removeClass('fa-lock text-slate-400').addClass('fa-unlock text-emerald-600');
            $('#leave_lock_text').text('Editing Active (Click to Lock)');
            $('#btn_toggle_leave_edit').removeClass('bg-white text-slate-700 border-slate-300').addClass('bg-emerald-50 text-emerald-700 border-emerald-300');
            $('#leave_status_badge, #sick_status_badge').html('<i class="fas fa-pen text-blue-500"></i>');
        } else {
            $('#leave, #sick')
                .prop('readonly', true)
                .attr('readonly', 'readonly')
                .addClass('bg-slate-100 text-slate-500 cursor-not-allowed')
                .removeClass('bg-white text-slate-800 border-blue-500 ring-1 ring-blue-500');
            $('#leave_lock_icon').removeClass('fa-unlock text-emerald-600').addClass('fa-lock text-slate-400');
            $('#leave_lock_text').text('Enable Leave Edit');
            $('#btn_toggle_leave_edit').removeClass('bg-emerald-50 text-emerald-700 border-emerald-300').addClass('bg-white text-slate-700 border-slate-300');
            $('#leave_status_badge, #sick_status_badge').html('<i class="fas fa-lock text-slate-400"></i>');
        }
    };

    $(document).on('click', '#btn_toggle_leave_edit', function(e) {
        window.toggleLeaveEditing(e);
    });

    $('#salaryModal').on('hidden.bs.modal', function () {
        window.leaveEditingEnabled = false;
        $('#leave, #sick')
            .prop('readonly', true)
            .attr('readonly', 'readonly')
            .addClass('bg-slate-100 text-slate-500 cursor-not-allowed')
            .removeClass('bg-white text-slate-800 border-blue-500 ring-1 ring-blue-500');
        $('#leave_lock_icon').removeClass('fa-unlock text-emerald-600').addClass('fa-lock text-slate-400');
        $('#leave_lock_text').text('Enable Leave Edit');
        $('#btn_toggle_leave_edit').removeClass('bg-emerald-50 text-emerald-700 border-emerald-300').addClass('bg-white text-slate-700 border-slate-300');
        $('#leave_status_badge, #sick_status_badge').html('<i class="fas fa-lock text-slate-400"></i>');
    });

    var url_updateSalary = "/account/updateSalary";
    $("#btn_updateSalary").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') || $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            employee_id: $('#id').val(),
            basic_pay: $('#basic_pay').val(),
            other_nt_pay: $('#other_nt_pay').val(),
            cola: $('#cola').val(),
            payroll_type: $('#payroll_type').val(),
            leave: $('#leave').val(),
            sick: $('#sick').val()
        };
        var type = "GET";
        var my_url = url_updateSalary;

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                $('#salaryModal').modal('hide');
                alertify.success(data.message || 'Rates updated successfully.');
                setTimeout(function() { location.reload(); }, 1200);
            },
            error: function (xhr) {
                var msg = 'An error occurred while saving.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alertify.error(msg);
            }
        });
    });

    var url_deduction = "/account/deductionSalary";
    $("#deduction-btn").click(function (e) {
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           })
            e.preventDefault();
           var sendData = {
               employee_id: $('#id').val(),
           }
            var type = "GET";
            var deduction_salary = url_deduction;
            console.log(sendData);
            $.ajax({
                type: type,
                url: deduction_salary,
                data: sendData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {

                }
            });
        });

    var url_updateAccount = "/employee/UpdateEmployeeAccount";
    //create new task / update existing task
    $("#updateAccount").on('click',function () {
        var formDataUpdate = {
            id : $('#id').val(),
            categories: $("#categories").is(':checked'),
            salary_status: $("#salary_status").is(':checked'),
            employee_id : $('#employee_id').val(),
            employee_Fname: $('#fname').val(),
            employee_Lname: $('#lname').val(),
            employee_Mname: $('#mname').val(),
            gender: $('#gender').val(),
            date_hired: $('#date_hired').val(),
            birth_date: $('#date_of_birth').val(),
            email: $('#email').val(),
            contactName: $('#Contactname').val() || null,
            contactNo: $('#ContactNo').val(),
            employment_status: $('#employmentStatus :selected').text(),
            employment_date_from: $('#employment_date_from').val(),
            employment_date_to: $('#employment_date_to').val(),
            department: $("#department :selected").text(),
            sub_department: $("#sub_department :selected").text(),
            status: $('#status').val(),
            address: $('#address').val(),
            sss: $('#sss_no').val(),
            tin: $('#tin').val(),
            hdmf: $('#hdmf').val(),
            philhealth: $('#phil_health').val(),
            ucpb: $('#ucpb').val(),
            passport : null,
            passport_exp : null,
        }
        console.log(formDataUpdate);
        var type = "GET";
        var my_url_update = url_updateAccount;
        $.ajax({
            type: type,
            url: my_url_update,
            data: formDataUpdate,
            dataType: 'json',
            success: function (data) {
                alertify.success('Account Update Successfully !');
            }
        });
    });
    var url = "/employee/addEmployee";
    //create new task / update existing task
    $("#btn-submit").click(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })


        e.preventDefault();

        var formData = {
            employee_id : $('#employee_id').val(),
            employee_Fname: $('#first_name').val(),
            employee_Lname: $('#last_name').val(),
            employee_Mname: $('#mid_name').val(),
            gender: $('#gender').val(),
            date_hired: $('#date_hired').val(),
            birth_date: $('#birth_date').val(),
            department: $('#department').val() ? $("#department :selected").text() : "",
            sub_department: $('#sub_department').val() ? $("#sub_department :selected").text() : "",
            status: $('#status').val(),
            address: $('#address').val(),
            contact_no: $('#contact_no').val(),
            sss: $('#sss_no').val(),
            tin: $('#tin').val(),
            hdmf: $('#hdmf').val(),
            philhealth: $('#phil_health').val(),
            ucpb: $('#ucpb').val(),
            passport : null,
            passport_exp : null,
            emp_email: $('#emp_email').val(),
        }

        if(formData.employee_id=="" ) {
            alertify.error("Employee I.D is required !");
            return;
        } else if(formData.employee_Lname=="" ) {
            alertify.error("LastName is required !");
            return;
        } else if(formData.employee_Fname=="" ) {
            alertify.error("FirstName is required !");
            return;
        } else if(formData.employee_Mname=="" ) {
            alertify.error("MiddleName is required !");
            return;
        } else if(formData.gender=="" || formData.gender==null) {
            alertify.error("Gender is required !");
            return;
        } else if(formData.date_hired=="" ) {
            alertify.error("Date Hired is required !");
            return;
        } else if(formData.birth_date=="" ) {
            alertify.error("Date of Birth is required !");
            return;
        } else if(formData.department=="" || formData.department==null) {
            alertify.error("Department is required !");
            return;
        } else if(formData.sub_department=="" || formData.sub_department==null) {
            alertify.error("SubGroup is required !");
            return;
        }

        var type = "GET";
        var my_url = url;
        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#addEmployee').modal('hide');
                location.reload();
            },
            error: function (data) {
                // console.log('Error:', data);
                alertify.error("An error occurred while adding the employee.");
            }
        });
    });
    $('#deductionModal').on('shown.bs.modal',function (e) {
        var tax = $('#tax').val(),
            sss = $('#sss_status').val(),
            philhealth = $('#phic_status').val(),
            pagibig = $('#pagibig').val();
       if(tax != "")
       {
           $('#tax_deduction').prop('checked', true);
       }
       else
       {
           $('#tax_deduction').prop('checked', false);
       }
        if(sss != "")
        {
            $('#sss_deduction').prop('checked', true);
        }
        else
        {
            $('#sss_deduction').prop('checked', false);
        }
       if (philhealth !="")
       {
           $('#phil_deduction').prop('checked', true);
       }
       else
       {
           $('#phil_deduction').prop('checked', false);
       }
       if(pagibig !="")
       {
           $('#pagibig_deduction').prop('checked', true);
       }
       else
       {
           $('#pagibig_deduction').prop('checked', false);
       }
    });
    $('#deduction_btn').on('click',function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })
        e.preventDefault();
        var tax , philhealth , pagibig , sss;
        if ($('#tax_deduction').prop('checked'))
        {
           tax = 1;
        }
        else
        {
            tax = "";
        }
        if ($('#phil_deduction').prop('checked'))
        {
            philhealth = 1;
        }
        else
        {
            philhealth = "";
        }
        if ($('#pagibig_deduction').prop('checked'))
        {
           pagibig = 1;
        }
        else
        {
            pagibig = "";
        }
        if ($('#sss_deduction').prop('checked'))
        {
          sss= 1;
        }
        else
        {
           sss = "";
        }

        var sendDeductionData = {
            id: $('#id_deduct').val(),
            tax: tax,
            philhealth: philhealth,
            pagibig: pagibig,
            sss : sss,
            pagibig_amount: $('#pagibig_amount').val()
        };
        console.log(sendDeductionData);
        $.ajax({
            type: "GET",
            url: "/employee/account/{id}/deductionData",
            data: sendDeductionData,
            dataType: 'json',
            success: function (data) {
                $('#deductionModal').remove();
                location.reload();
            },
            error: function (data) {

            }
        });
    });
    $( "#employmentStatus" ).change(function() {
        // console.log($('#employmentStatus').val())
        if($('#employmentStatus').val() == 2)
        {
            $('#employment_date_from').prop('disabled',false);
            $('#employment_date_to').prop('disabled',false);
        }
        else
        {
            $('#employment_date_from').prop('disabled',true);
            $('#employment_date_to').prop('disabled',true);
            $('#employment_date_from').val('');
            $('#employment_date_to').val('');
        }
    });


});