<?php

namespace SGpayroll;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'name', 'email', 'password',
=======
        'name', 'email', 'password', 'user_type', 'employee_id', 'profile_picture'
>>>>>>> branch1
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
<<<<<<< HEAD
=======

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
>>>>>>> branch1
}
