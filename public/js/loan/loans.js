$(document).ready(function(){
    $('#department').on('change',function () {
        var formData = {
            department: $('#department option:selected').text()
        };
        $.ajax({
            type: "GET",
            url: "/loans/deptEmployee",
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var appendData = '';
                $.each(data, function (index, employee) {
                    appendData += '<option value="'+ employee.id+'">'+employee.employee_Lname+', '+employee.employee_Fname+' </option>'
                })
                $('#employee_name').html(appendData)
            }
        });
    });
    $('#loan_type').on('change',function () {
        if($('#loan_type option:selected').val()==3 || $('#loan_type option:selected').val()==7 )
        {
            $('#promissory_note').prop('disabled',false);
        }
        else
        {
            $('#promissory_note').prop('disabled',true);
        }
        if($('#loan_type option:selected').val()==7)
        {
            $('#original_term').prop('disabled',true);
            $('#remaining_term').prop('disabled',true);
            $('#amountLoan').prop('disabled',true);
            $('#interest').prop('disabled',true);
            $('#totalLoan').prop('disabled',true);
            $('#balance').prop('disabled',true);
        }
    });
    $(document).on('show.bs.modal','.bd-example-modal-sm', function (e) {
        var link     = $(e.relatedTarget),
            id = link.data("id");
        $('#id').val(id);
        console.log(id);
    });
    var url_delete = "/loans/deleteLoanData";
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
   $('#submit-loans').on('click',function () {
       var loanData = {
           id: $('#id').val(),
           loan_type: $('#loan_type option:selected').val(),
           loan_name: $('#loan_type option:selected').text(),
           promissory: $('#promissory_note').val(),
           employee_id: $('#employee_id').val(),
           date_granted: $('#date_granted').val(),
           deduction_date: $('#date_started').val(),
           original_term: $('#original_term').val(),
           remaining_term: $('#remaining_term').val(),
           amountLoan: $('#amountLoan').val(),
           interest: $('#interest').val(),
           totalLoans: $('#totalLoan').val(),
           deduction: $('#deduction').val(),
           balance: $('#balance').val(),
           active: $('#status').prop('checked')
       };
       $.ajax({
           type: "GET",
           url: "/loans/insertLoanData",
           data: loanData,
           dataType: 'json',
           success: function (data) {
               location.reload();
           }
       });
   });
    $(document).on('show.bs.modal','#editLoan', function (e) {
        var link  = $(e.relatedTarget);
        var loanData = {
            id: link.data('id'),
        };
        $.ajax({
            type: "GET",
            url: "/loans/getLoanData",
            data: loanData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#editId').val(data.id);
                $('#edit_loan_type option:selected').text(data.loan_name);
                $('#edit_date_deduction').val(data.deduction_date);
                $('#edit_original_term').val(data.original_term);
                $('#edit_remaining_term').val(data.remaining_term);
                $('#edit_amountLoan').val(data.loan_amount);
                $('#edit_interest').val(data.interest);
                $('#edit_totalLoan').val(data.total_laon);
                $('#edit_deduction').val(data.deduction);
                $('#edit_balance').val(data.balance);
                if(data.active =='true')
                {
                    $('#EditStatus').prop('checked',true);
                }
                else
                {
                    $('#EditStatus').prop('checked',false);
                }


            }
        });
    });
    $('#editLoanBtn').on('click',function (e) {
        var editLoanData = {
            id: $('#editId').val(),
            // date_granted: $('#edit_date_sta').val(),
            deduction_date: $('#edit_date_deduction').val(),
            original_term: $('#edit_original_term').val(),
            remaining_term: $('#edit_remaining_term').val(),
            amountLoan: $('#edit_amountLoan').val(),
            interest: $('#edit_interest').val(),
            totalLoans: $('#edit_totalLoan').val(),
            deduction: $('#edit_deduction').val(),
            balance: $('#edit_balance').val(),
            active: $('#EditStatus').prop('checked')
        };
        $.ajax({
            type: "GET",
            url: "/loans/updateLoanData",
            data: editLoanData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                location.reload();
            }
        });
    });




});