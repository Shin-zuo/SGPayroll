<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
<<<<<<< HEAD
    protected $table = 'loans';
=======
    //
    protected $table='loans';
>>>>>>> branch1
    protected $fillable = [
      'loan_type_name','loan_id'
    ];
}
