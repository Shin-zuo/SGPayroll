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
            $table->string('address')->nullable();
            $table->string('sss_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_exp')->nullable();
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
