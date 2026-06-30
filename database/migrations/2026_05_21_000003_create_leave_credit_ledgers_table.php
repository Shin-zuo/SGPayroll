<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCreditLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_credit_ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->enum('leave_type', ['vacation', 'sick']);
            $table->smallInteger('year');
            $table->decimal('credit_limit', 5, 1)->default(0); // annual days granted
            $table->decimal('used_days', 5, 1)->default(0);    // consumed via approved leaves
            $table->timestamps();

            $table->unique(['employee_id', 'leave_type', 'year']); // one record per type per year
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_credit_ledgers');
    }
}
