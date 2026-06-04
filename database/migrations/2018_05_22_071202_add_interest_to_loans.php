<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterestToLoans extends Migration
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
            $table->string('interest')->nullable()->after('semester');
            $table->string('remaining_term')->nullable()->after('loan_amount');
            $table->string('balance')->nullable()->after('deduction');
<<<<<<< HEAD
            $table->integer('status')->nullable()->after('balance');
=======
            $table->integer('status')->nullable();
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
        Schema::table('employee_loans', function (Blueprint $table) {
            //
        });
    }
}
