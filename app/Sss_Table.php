<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Sss_Table extends Model
{
    //
    protected $table = 'sss_table';
    protected $fillable = [
        'range_from','range_to','sss_er','ec_er','sss_ee','provident_fund','total'
    ];

}
