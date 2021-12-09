<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWitholdingTaxtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('witholding_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salary_from')->nullable();
            $table->string('salary_to')->nullable();
            $table->string('prescribe_tax')->nullable();
            $table->string('tax_percentage')->nullable();
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
        Schema::dropIfExists('witholding_table');
    }
}
