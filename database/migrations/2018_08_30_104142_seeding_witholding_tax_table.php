<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedingWitholdingTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $witholding = [
            ['0','10416.99','0','0',],
            ['10417','16666.99','0','20'],
            ['16667','33332.99','1250','25'],
            ['33333','83332.99','5416.67','30'],
            ['83333','333332.99','20416.67','32'],
            ['333333','99999999999','100416.67','35']
        ];
        foreach ($witholding as $witholding_table)
        {
            \SGpayroll\Witholding_Table::create([
                'salary_from' => $witholding_table[0],
                'salary_to' => $witholding_table[1],
                'prescribe_tax' => $witholding_table[2],
                'tax_percentage' => $witholding_table[3],
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
        Schema::table('witholding_table', function (Blueprint $table) {
            //
        });
    }
}
