<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code')->nullable();
            $table->string('work_day')->nullable();
            $table->string('overtime_pay')->nullable();
            $table->string('holiday_pay')->nullable();
            $table->string('leave_pay')->nullable();
            $table->string('other_taxable_pay')->nullable();
            $table->string('other_non_taxable_pay')->nullable();
            $table->string('gross_pay')->nullable();
            $table->string('witholding_tax')->nullable();
            $table->string('sss_contribution')->nullable();
            $table->string('phil_health_contribution')->nullable();
            $table->string('pag_ibig_contribution')->nullable();
            $table->string('union_contribution')->nullable();
            $table->string('insurance_contribution')->nullable();
            $table->string('sss_loans')->nullable();
            $table->string('pag_ibig_loans')->nullable();
            $table->string('other_loans')->nullable();
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
        Schema::dropIfExists('payroll_employees');
    }
}
