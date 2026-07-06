<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLockedAtToLeaveCreditLedgersTable extends Migration
{
    public function up()
    {
        Schema::table('leave_credit_ledgers', function (Blueprint $table) {
            // When populated, this employee's leave credit for that year is locked
            $table->timestamp('locked_at')->nullable()->after('used_days');
        });
    }

    public function down()
    {
        Schema::table('leave_credit_ledgers', function (Blueprint $table) {
            $table->dropColumn('locked_at');
        });
    }
}
