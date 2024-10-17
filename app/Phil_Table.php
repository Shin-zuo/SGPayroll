<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Phil_Table extends Model
{
    //
    protected $table = 'phil_table';
    protected $fillable = [
        'range_from','range_to','monthy_premium','personal_share','employer_share'
    ];
}
