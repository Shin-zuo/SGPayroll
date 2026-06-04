<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoansToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->string('sss_loan_deduction')->nullable()->after('loan');
<<<<<<< HEAD
            $table->string('pagibig_loan_deduction')->nullable()->after('sss_loan_deduction');
            $table->string('company_loan_deduction')->nullable()->after('pagibig_loan_deduction');
=======
            $table->string('pagibig_loan_deduction')->nullable();
            $table->string('company_loan_deduction')->nullable();
>>>>>>> branch1
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
