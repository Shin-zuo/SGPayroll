<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Witholding_Table extends Model
{
    //
    protected $table = 'witholding_table';
    protected $fillable = [
        'salary_from',
        'salary_to',
        'prescribe_tax',
        'tax_percentage'
    ];
}
