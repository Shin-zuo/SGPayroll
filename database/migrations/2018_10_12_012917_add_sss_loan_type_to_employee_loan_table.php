<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSssLoanTypeToEmployeeLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_loans', function (Blueprint $table) {
            //
            $table->string('sss_loan_type')->nullable()->after('loan_name');
            $table->string('promissory_note')->nullable()->after('sss_loan_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_loans', function (Blueprint $table) {
            //
        });
    }
}
