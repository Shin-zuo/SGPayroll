<?php

namespace SGpayroll;

use Illuminate\Database\Eloquent\Model;

class Sub_Department extends Model
{
    //
    protected $table = 'sub_departments';
    protected $fillable = [
       'sub_department_name','department_code'
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
