$(document).ready(function(){
    $(document).on('show.bs.modal','#periodModal', function (e) {


        $("#savePeriod").click(function () {
            var link     = $(e.relatedTarget);
            var formData = {
                id : link.data("id"),
                date_from : $('#date_from').val(),
                date_to : $('#date_to').val()
            }
            var updateUrl = "/department/update-period";
            console.log($('#date_from').val());
                var type = "GET";
                $.ajax({
                    type: type,
                    url: updateUrl,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                    },
                });
        })
    });
    $(document).on('show.bs.modal','#editDepartmentModal', function (e) {
        var link     = $(e.relatedTarget);
        $('#edit_group_name').val(link.data("name"));
        $('#edit_group_code').val(link.data("code"));
        $('#edit_employer_tin').val(link.data('tin'));
        $('#edit_employer_sss').val(link.data('sss'));
        $('#edit_group_address').text(link.data("address"));
        $('#edit_employer_telNo').val(link.data('telno'));
        $('#edit_employer_zip').val(link.data('zip'));
        $("#editNameGroup").click(function () {
            var formDataEdit = {
                id : link.data("id"),
                old_code: link.data("code"),
                name: $('#edit_group_name').val(),
                code: $('#edit_group_code').val(),
                tin: $('#edit_employer_tin').val(),
                sss: $('#edit_employer_sss').val(),
                telno: $('#edit_employer_telNo').val(),
                address: $('#edit_group_address').val(),
                zip: $('#edit_employer_zip').val(),
                payroll_type: $('select[name=edit_payroll_type] option:selected').val(),
                month13From: $('#edit_13monthFrom').val(),
                month13To: $('#edit_13monthTo').val(),
            };
            console.log(formDataEdit);
            var updateUrl = "/department/update-group";
            console.log($('#date_from').val());
            var type = "GET";
            $.ajax({
                type: type,
                url: updateUrl,
                data: formDataEdit,
                dataType: 'json',
                success: function (data) {
                   location.reload();
                },
            });
        })
    });
    $(document).on('hide.bs.modal', '#editDepartmentModal', function (e) {
       location.reload();
    });
    var url = "department/addGroup/addGroups";
    var url_subgGroup = "/department/{id}/addSubGroup";

    //create new task / update existing task
    $("#btn_addGroup").click(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })


        e.preventDefault();

        var formData = {
            employer_tin: $('#employer_tin').val(),
            employer_sss: $('#employer_sss').val(),
            group_name: $('#group_name').val(),
            group_code: $('#group_code').val(),
            employer_no: $('#employer_telNo').val(),
            group_address: $('#group_address').val(),
            zip: $('#employer_zip').val(),
            payroll_type: $('select[name=payroll_type] option:selected').val()
        };
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
            },
            error: function (data) {
                // console.log('Error:', data);
                if(formData.group_name=="")
                {
                    alertify.error("Group Name is required !")
                }
                else
                {
                    $('#addDepartmentModal').remove();
                    location.reload();
                }

            }
        });
    });
    $("#btn_addSubGroup").click(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })

        e.preventDefault();

        var formData = {
            sub_group_name: $('#sub_group_name').val(),
            generated_code: $('#generated_code').val(),
        }

        var type = "GET";
        var my_url = url_subgGroup;
        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                // console.log('Error:', data);
                if(formData.group_name=="" )
                {
                    alertify.error("SubGroup Name is required !")
                }
                else
                {
                    $('#addSubDepartmentModal').remove();
                    location.reload();
                }

            }
        });
    });
});