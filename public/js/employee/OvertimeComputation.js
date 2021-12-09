$(document).ready(function(){
    $('#computeOtherPay').click(function (e) {
        var formData = {
            overtimeHours: $('input[name="otherInputOT"]').val(),
            nightDiffHours: $('input[name="otherInputND"]').val(),
            nightDiffOvertime: $('input[name="otherInputOtNd"]').val()
        }
        $.ajax({
            type: "GET",
            url: "/employee/account/{id}/other-computation/computeOther",
            data: formData,
            dataType: 'json',
        });
        console.log(formData);
    })
});