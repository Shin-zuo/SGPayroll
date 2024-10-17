<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalGrosspayToEmployeePayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            //
            $table->string('gross_pay')->nullable()->after('payroll_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            //
        });
    }
}
