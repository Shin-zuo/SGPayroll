<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('range_from')->nullable();
            $table->string('range_to')->nullable();
            $table->string('sss_er')->nullable();
            $table->string('ec_er')->nullable();
            $table->string('sss_ee')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('sss_table');
    }
}
