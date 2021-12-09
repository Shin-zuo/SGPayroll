<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhilhealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phil_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('range_from')->nullable();
            $table->string('range_to')->nullable();
            $table->string('monthy_premium')->nullable();
            $table->string('personal_share')->nullable();
            $table->string('employer_share')->nullable();
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
        Schema::dropIfExists('phil_table');
    }
}
