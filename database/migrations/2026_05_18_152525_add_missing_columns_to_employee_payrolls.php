<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingColumnsToEmployeePayrolls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            $table->decimal('hdmf_calamity_loan', 10, 2)->default(0.00);
            $table->decimal('gross_deducted_witholding', 10, 2)->default(0.00);
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
            $table->dropColumn(['hdmf_calamity_loan', 'gross_deducted_witholding']);
        });
    }
}
