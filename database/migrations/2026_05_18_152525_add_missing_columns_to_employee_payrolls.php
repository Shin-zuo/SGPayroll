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
        // Columns already exist due to partial migration failure.
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
