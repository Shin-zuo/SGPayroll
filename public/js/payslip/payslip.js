$(document).ready(function() {
    var url_subgroup = "/payslip/requestDataPayslip";
    $('#department').on('change', function() {
        var formData = {
            group_id: $('#department').val(),
        };
        var type = "GET";
        var url_subgroups = url_subgroup;
        $.ajax({
            type: type,
            url: url_subgroups,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var appendData = '';
                $.each(data, function (index, employee) {
                    appendData += '<option value="'+ employee.id+'">'+employee.employee_id+' '+"-"+'  '+employee.employee_Lname+''+","+' '+employee.employee_Fname+'</option>'
                })
                $('#employee_id').html(appendData)
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });

    ///////////////////////////////////////////////////////////////////////////////////////////////
    $('input').on('click',function () {
        if ($('#print_all').is(':checked')) {
            $( "#employee_id" ).prop( "disabled", true );
        } else {
            $( "#employee_id" ).prop( "disabled", false );
        }
    });


} );