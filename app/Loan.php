<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    protected $table='loans';
    protected $fillable = [
      'loan_type_name','loan_id'
    ];
}
