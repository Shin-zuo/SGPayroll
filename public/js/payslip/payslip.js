$(document).ready(function() {
    var url_subgroup = "/payslip/requestDataPayslip";

    // Format employee option with status badge in Select2
    function formatEmployeeOption(state) {
        if (!state.id) {
            return state.text;
        }
        var $element = $(state.element);
        var empStatus = $element.data('status');
        var statusBadge = '';
        if (empStatus == '1' || empStatus == 1) {
            statusBadge = '<span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">Active</span>';
        } else if (empStatus == '2' || empStatus == 2) {
            statusBadge = '<span style="background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">Inactive</span>';
        }

        var $res = $(
            '<div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">' +
                '<div>' +
                    '<span style="font-weight: 600; color: #1e293b;">' + state.text + '</span>' +
                '</div>' +
                '<div>' + statusBadge + '</div>' +
            '</div>'
        );
        return $res;
    }

    function formatEmployeeSelection(state) {
        return state.text;
    }

    // Initialize Select2 on employee select
    function initEmployeeSelect2() {
        if ($.fn.select2) {
            $('#employee_id').select2({
                placeholder: "-- Choose employee from department --",
                allowClear: true,
                width: '100%',
                templateResult: formatEmployeeOption,
                templateSelection: formatEmployeeSelection,
                language: {
                    noResults: function () {
                        return "No matching employees found";
                    }
                }
            });
        }
    }

    // Load department employees with active/inactive status filter
    function loadDepartmentEmployees() {
        var deptVal = $('#department').val();
        var statusVal = $('#employee_status_filter').val() || '1';

        if (!deptVal) {
            $('#employee_id').empty().append('<option value="">-- Choose employee from department --</option>').trigger('change');
            return;
        }

        // Loading state
        $('#employee_id').empty().append('<option value="">Loading employees...</option>').prop('disabled', true).trigger('change');

        $.ajax({
            type: "GET",
            url: url_subgroup,
            data: {
                group_id: deptVal,
                status: statusVal
            },
            dataType: 'json',
            success: function (data) {
                var appendData = '<option value="">-- Choose employee from department --</option>';
                if (data && data.length > 0) {
                    $.each(data, function (index, employee) {
                        var fullName = (employee.employee_Lname ? employee.employee_Lname : '') + ', ' + (employee.employee_Fname ? employee.employee_Fname : '');
                        var displayText = (employee.employee_id ? employee.employee_id : 'ID') + ' - ' + fullName;
                        appendData += '<option value="' + employee.id + '" data-code="' + employee.employee_id + '" data-status="' + employee.employee_status + '">' + displayText + '</option>';
                    });
                } else {
                    var statusLabel = statusVal === '1' ? 'active' : (statusVal === '2' ? 'inactive' : '');
                    appendData = '<option value="">-- No ' + statusLabel + ' employees found in ' + deptVal + ' --</option>';
                }

                $('#employee_id').empty().append(appendData);

                // Re-sync disabled state based on print_all
                if ($('#print_all').is(':checked')) {
                    $('#employee_id').prop('disabled', true);
                } else {
                    $('#employee_id').prop('disabled', false);
                }
                $('#employee_id').val('').trigger('change');
            },
            error: function (xhr) {
                console.error('Error loading employees:', xhr);
                $('#employee_id').empty().append('<option value="">-- Failed to load employees --</option>').prop('disabled', false).trigger('change');
            }
        });
    }

    // When department changes, load employees
    $('#department').on('change', function() {
        loadDepartmentEmployees();
    });

    // When status toggle buttons are clicked (Active / Inactive / All)
    $(document).on('click', '.btn-emp-status', function(e) {
        e.preventDefault();
        var newStatus = $(this).data('status');

        // Toggle button styles
        $('.btn-emp-status').removeClass('active bg-white text-blue-700 shadow-xs border border-slate-200/60')
                            .addClass('text-slate-600 hover:text-slate-900');
        $(this).removeClass('text-slate-600 hover:text-slate-900')
               .addClass('active bg-white text-blue-700 shadow-xs border border-slate-200/60');

        $('#employee_status_filter').val(newStatus);

        // If department already chosen, reload employees immediately
        if ($('#department').val()) {
            loadDepartmentEmployees();
        }
    });

    // Toggle Print All vs Specific Employee
    function syncPrintAll() {
        var isPrintAll = $('#print_all').is(':checked');
        if (isPrintAll) {
            $("#employee_id").prop("disabled", true).trigger('change');
            $('#employee_select_wrapper').addClass("opacity-60");
            $('.btn-emp-status').prop('disabled', true).addClass('pointer-events-none opacity-50');
        } else {
            $("#employee_id").prop("disabled", false).trigger('change');
            $('#employee_select_wrapper').removeClass("opacity-60");
            $('.btn-emp-status').prop('disabled', false).removeClass('pointer-events-none opacity-50');
        }
    }

    $('#print_all').on('change', function () {
        syncPrintAll();
    });

    // Initialize Select2 and initial state
    initEmployeeSelect2();
    syncPrintAll();

    // Handle Delete Payslip with Loan Reversal
    $(document).on('click', '.btn-delete-payslip', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var employeeName = $(this).data('employee');

        var confirmHtml = '' +
            '<div class="text-sm">' +
            '   <p class="mb-3">Are you sure you want to delete payslip <strong class="text-slate-800">#' + id + '</strong> for <strong class="text-slate-800">' + employeeName + '</strong>?</p>' +
            '   <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 text-xs text-amber-800 leading-relaxed">' +
            '       <i class="fas fa-shield-alt text-amber-600 mr-1.5"></i>' +
            '       <strong>Automatic Loan Rollback:</strong> Any loans deducted for this payroll period (SSS, HDMF, Calamity, Coop, Insurance) will have their remaining terms restored (+1 term) and deducted payments refunded back to the loan balance.' +
            '   </div>' +
            '</div>';

        alertify.confirm(
            'Confirm Delete Payslip',
            confirmHtml,
            function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'DELETE',
                    url: '/payslip/' + id,
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            alertify.success(res.message || 'Payslip deleted successfully.');
                            $('#payslip-row-' + id).fadeOut(400, function() {
                                $(this).remove();
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            });
                        } else {
                            alertify.error(res.message || 'Failed to delete payslip.');
                        }
                    },
                    error: function (xhr) {
                        var err = 'Failed to delete payslip.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            err = xhr.responseJSON.message;
                        }
                        alertify.error(err);
                    }
                });
            },
            function () {
                // Cancelled
            }
        ).set('labels', {ok: 'Yes, Delete & Revert Loans', cancel: 'Cancel'});
    });

    var originalPayslipData = null;

    // Helper: format currency
    function formatCurrency(val) {
        var num = parseFloat(val);
        if (isNaN(num)) num = 0;
        return '₱' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Live calculation of Gross Pay, Section Subtotals, Deductions, and Net Pay
    function recalculateLiveTotals() {
        var gross = 0;
        $('.edit-calc-earning').each(function() {
            var v = parseFloat($(this).val());
            if (!isNaN(v)) gross += v;
        });

        var statutory = 0;
        $('.edit-calc-statutory').each(function() {
            var v = parseFloat($(this).val());
            if (!isNaN(v)) statutory += v;
        });

        var loans = 0;
        $('.edit-calc-loan').each(function() {
            var v = parseFloat($(this).val());
            if (!isNaN(v)) loans += v;
        });

        var deductions = 0;
        $('.edit-calc-deduction').each(function() {
            var v = parseFloat($(this).val());
            if (!isNaN(v)) deductions += v;
        });

        var net = Math.max(0, gross - deductions);

        // Update live header KPI cards
        $('#live_gross_pay').text(formatCurrency(gross));
        $('#live_total_deductions').text(formatCurrency(deductions));
        $('#live_net_pay').text(formatCurrency(net));

        // Update section headers and tab badges
        $('#subtotal_earnings, #subtotal_earnings_badge').text(formatCurrency(gross));
        $('#subtotal_statutory, #subtotal_statutory_badge').text(formatCurrency(statutory));
        $('#subtotal_loans, #subtotal_loans_badge').text(formatCurrency(loans));
    }

    // Trigger recalculation on input changes
    $(document).on('input keyup change', '.edit-calc-earning, .edit-calc-deduction', function() {
        recalculateLiveTotals();
    });

    // Populate all modal fields from a payslip object
    function populateEditFields(p) {
        // Earnings & Additions
        $('#edit_work_days').val(p.work_days !== null ? p.work_days : '');
        $('#edit_work_days_amount').val(p.work_days_amount !== null ? parseFloat(p.work_days_amount).toFixed(2) : '0.00');
        $('#edit_overtime').val(p.overtime !== null ? p.overtime : '');
        $('#edit_overtime_amount').val(p.overtime_amount !== null ? parseFloat(p.overtime_amount).toFixed(2) : '0.00');
        $('#edit_ext_reg_hrs').val(p.ext_reg_hrs !== null ? p.ext_reg_hrs : '');
        $('#edit_ext_reg_hrs_ammount').val(p.ext_reg_hrs_ammount !== null ? parseFloat(p.ext_reg_hrs_ammount).toFixed(2) : '0.00');
        $('#edit_night_diff_amount').val(p.night_diff_amount !== null ? parseFloat(p.night_diff_amount).toFixed(2) : '0.00');
        $('#edit_night_diff_restday_amount').val(p.night_diff_restday_amount !== null ? parseFloat(p.night_diff_restday_amount).toFixed(2) : '0.00');
        $('#edit_rest_special_amount').val(p.rest_special_amount !== null ? parseFloat(p.rest_special_amount).toFixed(2) : '0.00');
        $('#edit_exc_rest_special_amount').val(p.exc_rest_special_amount !== null ? parseFloat(p.exc_rest_special_amount).toFixed(2) : '0.00');
        $('#edit_regular_holiday_amount').val(p.regular_holiday_amount !== null ? parseFloat(p.regular_holiday_amount).toFixed(2) : '0.00');
        $('#edit_exc_regular_holiday_amount').val(p.exc_regular_holiday_amount !== null ? parseFloat(p.exc_regular_holiday_amount).toFixed(2) : '0.00');
        $('#edit_vacation_leave_amount').val(p.vacation_leave_amount !== null ? parseFloat(p.vacation_leave_amount).toFixed(2) : '0.00');
        $('#edit_sick_leave_amount').val(p.sick_leave_amount !== null ? parseFloat(p.sick_leave_amount).toFixed(2) : '0.00');
        $('#edit_cola_amount').val(p.cola_amount !== null ? parseFloat(p.cola_amount).toFixed(2) : '0.00');
        $('#edit_commission').val(p.commission !== null ? parseFloat(p.commission).toFixed(2) : '0.00');
        $('#edit_hazard_pay').val(p.hazard_pay !== null ? parseFloat(p.hazard_pay).toFixed(2) : '0.00');
        $('#edit_non_tax_other').val(p.non_tax_other !== null ? parseFloat(p.non_tax_other).toFixed(2) : '0.00');
        $('#edit_regular_other').val(p.regular_other !== null ? parseFloat(p.regular_other).toFixed(2) : '0.00');

        // Statutory & Other Deductions
        $('#edit_witholding_tax').val(p.witholding_tax !== null ? parseFloat(p.witholding_tax).toFixed(2) : '0.00');
        $('#edit_sss_contribution').val(p.sss_contribution !== null ? parseFloat(p.sss_contribution).toFixed(2) : '0.00');
        $('#edit_phic_contribution').val(p.phic_contribution !== null ? parseFloat(p.phic_contribution).toFixed(2) : '0.00');
        $('#edit_hdmf_contribution').val(p.hdmf_contribution !== null ? parseFloat(p.hdmf_contribution).toFixed(2) : '0.00');
        $('#edit_provident_fund').val(p.provident_fund !== null ? parseFloat(p.provident_fund).toFixed(2) : '0.00');
        $('#edit_rent').val(p.rent !== null ? parseFloat(p.rent).toFixed(2) : '0.00');

        // Loan Deductions
        $('#edit_sss_loan').val(p.sss_loan !== null ? parseFloat(p.sss_loan).toFixed(2) : '0.00');
        $('#edit_sss_calamity_loan').val(p.sss_calamity_loan !== null ? parseFloat(p.sss_calamity_loan).toFixed(2) : '0.00');
        $('#edit_hdmf_loan').val(p.hdmf_loan !== null ? parseFloat(p.hdmf_loan).toFixed(2) : '0.00');
        $('#edit_hdmf_calamity_loan').val(p.hdmf_calamity_loan !== null ? parseFloat(p.hdmf_calamity_loan).toFixed(2) : '0.00');
        $('#edit_sss_emergency_loan').val(p.sss_emergency_loan !== null ? parseFloat(p.sss_emergency_loan).toFixed(2) : '0.00');
        $('#edit_other_loan').val(p.other_loan !== null ? parseFloat(p.other_loan).toFixed(2) : '0.00');
        $('#edit_company_loan').val(p.company_loan !== null ? parseFloat(p.company_loan).toFixed(2) : '0.00');
        $('#edit_insurance').val(p.insurance !== null ? parseFloat(p.insurance).toFixed(2) : '0.00');
    }

    // Tab Filtering Logic
    $(document).on('click', '.edit-modal-tab', function() {
        $('.edit-modal-tab').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).data('tab');

        if (tab === 'all') {
            $('#modal_sections_wrapper').css({
                'display': 'grid',
                'grid-template-columns': '1.05fr 0.95fr',
                'gap': '20px'
            });
            $('#section_earnings_col').show();
            $('#section_deductions_col').show();
            $('#card_statutory').show();
            $('#card_loans').show();
        } else if (tab === 'earnings') {
            $('#modal_sections_wrapper').css({
                'display': 'block'
            });
            $('#section_earnings_col').show();
            $('#section_deductions_col').hide();
        } else if (tab === 'statutory') {
            $('#modal_sections_wrapper').css({
                'display': 'block'
            });
            $('#section_earnings_col').hide();
            $('#section_deductions_col').show();
            $('#card_statutory').show();
            $('#card_loans').hide();
        } else if (tab === 'loans') {
            $('#modal_sections_wrapper').css({
                'display': 'block'
            });
            $('#section_earnings_col').hide();
            $('#section_deductions_col').show();
            $('#card_statutory').hide();
            $('#card_loans').show();
        }
    });

    // Reset to Original Values Button
    $(document).on('click', '#btn_reset_payslip_fields', function() {
        if (!originalPayslipData) return;
        populateEditFields(originalPayslipData);
        recalculateLiveTotals();
        alertify.message('Fields reverted to original payslip values.');
    });

    // Handle Edit Payslip Button Click
    $(document).on('click', '.btn-edit-payslip', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $btn = $(this);
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            type: 'GET',
            url: '/payslip/' + id + '/edit',
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);
                if (!res.success || !res.payslip) {
                    alertify.error('Failed to load payslip data.');
                    return;
                }

                var p = res.payslip;
                originalPayslipData = p;

                var emp = p.employee;
                var empName = emp ? (emp.employee_Fname + ' ' + (emp.employee_Mname ? emp.employee_Mname + ' ' : '') + emp.employee_Lname) : ('Employee #' + p.employee_code);
                var empCode = emp ? emp.employee_id : p.employee_code;
                var dept = (emp && emp.departments && emp.departments.department_name) ? emp.departments.department_name : (p.department || 'Department');
                var period = p.date_from + ' to ' + p.date_to;
                var initials = 'EP';
                if (emp && emp.employee_Fname) {
                    initials = emp.employee_Fname.charAt(0).toUpperCase() + (emp.employee_Lname ? emp.employee_Lname.charAt(0).toUpperCase() : '');
                }

                $('#edit_payslip_id').text(p.id);
                $('#edit_payslip_hidden_id').val(p.id);
                $('#edit_emp_initials').text(initials);
                $('#edit_emp_name').text(empName);
                $('#edit_emp_code').text(empCode);
                $('#edit_emp_dept').text(dept);
                $('#edit_payroll_period').text(period);
                $('#edit_payroll_number').text('Payroll #' + (p.payroll_number || '1'));
                $('#edit_employee_subtitle').text(empName + ' (ID: ' + empCode + ') • ' + dept + ' • Period: ' + period + ' • Payroll #' + p.payroll_number);

                // Reset Tab to 'all'
                $('.edit-modal-tab[data-tab="all"]').click();

                // Populate Fields
                populateEditFields(p);

                recalculateLiveTotals();
                $('#editPayslipModal').modal('show');
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(origHtml);
                alertify.error('Failed to retrieve payslip details.');
            }
        });
    });

    // Handle Edit Form Submission
    $('#editPayslipForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_payslip_hidden_id').val();
        if (!id) return;

        var $saveBtn = $('#btn_save_payslip');
        $saveBtn.prop('disabled', true);
        $('#btn_save_payslip_text').html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving...');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/payslip/' + id,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                $saveBtn.prop('disabled', false);
                $('#btn_save_payslip_text').text('Save Changes');

                if (res.success) {
                    alertify.success(res.message || 'Payslip updated successfully.');
                    $('#editPayslipModal').modal('hide');

                    // Update table row values live
                    var $row = $('#payslip-row-' + id);
                    if ($row.length) {
                        $row.find('.col-gross-pay').text('₱' + res.gross_pay);
                        $row.find('.col-total-deductions').text('₱' + res.total_deduction);
                        $row.find('.col-net-pay').text('₱' + res.net_pay);

                        $row.addClass('bg-blue-50');
                        setTimeout(function() {
                            $row.removeClass('bg-blue-50');
                        }, 1800);
                    }
                } else {
                    alertify.error(res.message || 'Failed to update payslip.');
                }
            },
            error: function(xhr) {
                $saveBtn.prop('disabled', false);
                $('#btn_save_payslip_text').text('Save Changes');
                var err = 'Failed to update payslip.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    err = xhr.responseJSON.message;
                }
                alertify.error(err);
            }
        });
    });
});