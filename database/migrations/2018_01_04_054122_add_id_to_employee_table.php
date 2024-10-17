<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdToEmployeeTable extends Migration
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
            $table->string('status')->nullable()->after('department');
            $table->string('address')->nullable()->after('status');
            $table->string('sss_number')->nullable()->after('address');
            $table->string('tin_number')->nullable()->after('sss_number');
            $table->string('philhealth_number')->nullable()->after('tin_number');
            $table->string('passport_number')->nullable()->after('philhealth_number');
            $table->string('passport_exp')->nullable()->after('passport_number');
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
