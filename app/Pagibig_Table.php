<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Pagibig_Table extends Model
{
    //
    protected $table= 'pagibig_talbe';
    protected $fillable = [
        'employe_code', 'employee_contribution'
    ];
}
