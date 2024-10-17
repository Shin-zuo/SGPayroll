<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHolidayMinimumToEmployeePayrollsTable extends Migration
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
            $table->string('regular_holiday_day_minimum')->nullable()->after('special_holiday_day_amount');
            $table->string('regular_holiday_day_minimum_amount')->nullable();
            $table->string('special_holiday_day_minimum')->nullable();
            $table->string('special_holiday_day_minimum_amount')->nullable();
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
