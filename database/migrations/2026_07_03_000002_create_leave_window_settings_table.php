<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveWindowSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('leave_window_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_open')->default(0);       // 1 = manually opened by super admin
            $table->unsignedInteger('opened_by')->nullable(); // user id who opened it
            $table->timestamp('opened_at')->nullable();
            $table->unsignedInteger('closed_by')->nullable(); // user id who closed it
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        // Seed the single-row default (closed)
        DB::table('leave_window_settings')->insert([
            'is_open'    => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('leave_window_settings');
    }
}
