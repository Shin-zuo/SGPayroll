<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code')->nullable();
            $table->string('work_days')->nullable();
            $table->string('work_days_amount')->nullable();
            $table->string('overtime')->nullable();
            $table->string('overtime_amount')->nullable();
            $table->string('ext_reg_hrs')->nullable();
            $table->string('ext_reg_hrs_ammount')->nullable();
            $table->string('night_diff')->nullable();
            $table->string('night_diff_amount')->nullable();
            $table->string('rest_special')->nullable();
            $table->string('rest_special_amount')->nullable();
            $table->string('exc_rest_special')->nullable();
            $table->string('exc_rest_special_amount')->nullable();
            $table->string('regular_holiday')->nullable();
            $table->string('regular_holiday_amount')->nullable();
            $table->string('exc_regular_holiday')->nullable();
            $table->string('exc_regular_holiday_amount')->nullable();
            $table->string('rest_on_regular')->nullable();
            $table->string('rest_on_regular_amount')->nullable();
            $table->string('exc_rest_on_regular')->nullable();
            $table->string('exc_rest_on_regular_amount')->nullable();
            $table->string('rest_on_special')->nullable();
            $table->string('rest_on_special_amount')->nullable();
            $table->string('exc_rest_on_special')->nullable();
            $table->string('exc_rest_on_special_amount')->nullable();
            $table->string('absent')->nullable();
            $table->string('absent_amount')->nullable();
            $table->string('late')->nullable();
            $table->string('late_amount')->nullable();
            $table->string('regular_holiday_day')->nullable();
            $table->string('regular_holiday_day_amount')->nullable();
            $table->string('sick_leave')->nullable();
            $table->string('sick_leave_amount')->nullable();
            $table->string('vacation_leave')->nullable();
            $table->string('vacation_leave_amount')->nullable();
            $table->string('service_leave')->nullable();
            $table->string('service_leave_amount')->nullable();
            $table->string('total_basic_pay')->nullable();
            $table->string('representation')->nullable();
            $table->string('transportation')->nullable();
            $table->string('cola')->nullable();
            $table->string('FHA')->nullable();
            $table->string('regular_other')->nullable();
            $table->string('commission')->nullable();
            $table->string('pro_sharing')->nullable();
            $table->string('hazard_pay')->nullable();
            $table->string('fees')->nullable();
            $table->string('supplementary_other')->nullable();
            $table->string('thirteen_month')->nullable();
            $table->string('non_tax_other')->nullable();
            $table->string('total_other_pay')->nullable();
            $table->string('payroll_number')->nullable();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->string('witholding_tax')->nullable();
            $table->string('sss_contribution')->nullable();
            $table->string('phic_contribution')->nullable();
            $table->string('hdmf_contribution')->nullable();
            $table->string('union')->nullable();
            $table->string('insurance')->nullable();
            $table->string('sss_loan')->nullable();
            $table->string('hdmf_loan')->nullable();
            $table->string('company_loan')->nullable();
            $table->string('other_loan')->nullable();
            $table->string('total_deduction')->nullable();
            $table->string('net_pay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_payrolls');
    }
}
