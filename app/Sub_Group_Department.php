<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Sub_Group_Department extends Model
{
    //
    protected $table = 'sub_group_departments';
    protected $fillable = [
        'sub_group_name',
        'sub_group_code',
        'sub_code_generated_code'
    ];
}
