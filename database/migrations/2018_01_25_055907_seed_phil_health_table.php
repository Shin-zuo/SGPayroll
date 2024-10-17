<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedPhilHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $philhealth = [
           ['0','10000.00','275.00','137.50','137.50'],
           ['10000.01','39999.99','computation','computation','computation'],
           ['40000.00','9999999999999.99','1100.00','550.00','550.00']
       ];
       foreach ($philhealth as $philhealth_table)
       {
           \SGpayroll\Phil_Table::create([
               'range_from' => $philhealth_table[0],
               'range_to' => $philhealth_table[1],
               'monthy_premium' => $philhealth_table[2],
               'personal_share' => $philhealth_table[3],
               'employer_share' => $philhealth_table[4],
           ]);
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phil_table', function (Blueprint $table) {
            //
        });
    }
}
