$(document).ready(function(){
    $('#report_type').change(function () {
        console.log($( "#report_type option:selected" ).val());
        if($( "#report_type option:selected" ).val() == 'Payroll')
        {
            $('#payroll_number').prop('disabled',false);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'Sss')
        {
            $('#payroll_number').prop('disabled',true);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'Pag-IBIG')
        {
            $('#payroll_number').prop('disabled',true);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'WITHOLDING TAX')
        {
            $('#payroll_number').prop('disabled',true);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'PHILHEALTH')
        {
            $('#payroll_number').prop('disabled',true);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'SSS LOANS')
        {
            $('#payroll_number').prop('disabled',false);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == '13 MONTH')
        {
            $('#quarter').show();
            $('#payroll_no').hide();
            $('#month').hide();
           
        }
        if($( "#report_type option:selected" ).val() == 'ALPHA LIST')
        {
            $('#payroll_number').prop('disabled',false);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
        if($( "#report_type option:selected" ).val() == 'EMPLOYEE INFORMATION')
        {
            $('#payroll_number').prop('disabled',false);
            $('#payroll_no').show();
            $('#dateTo').hide();
            $('#month').show();
            $('#quarter').hide();
        }
    });

});