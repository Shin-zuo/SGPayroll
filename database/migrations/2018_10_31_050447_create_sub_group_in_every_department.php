<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubGroupInEveryDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_group_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sub_group_name')->nullable();
            $table->string('sub_group_code')->nullable();
            $table->string('sub_code_generated_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_group_departments');
    }
}
