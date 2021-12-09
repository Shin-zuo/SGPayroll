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
            $table->string('contactName')->nullable()->after('email');
            $table->string('contactNo')->nullable()->after('contactName');
            $table->string('employment_status')->nullable()->after('contactNo');
            $table->string('employment_date_from')->nullable()->after('employment_status');
            $table->string('employment_date_to')->nullable()->after('employment_date_from');

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
