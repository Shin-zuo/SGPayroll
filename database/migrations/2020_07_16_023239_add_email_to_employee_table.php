<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailToEmployeeTable extends Migration
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
            $table->string('email')->nullable()->after('address');
            $table->string('contactName')->nullable();
            $table->string('contactNo')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('employment_date_from')->nullable();
            $table->string('employment_date_to')->nullable();

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
