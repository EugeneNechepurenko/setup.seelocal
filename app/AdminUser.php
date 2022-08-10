<?php

namespace App;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
public $timestamps = false;
    protected $table = 'admin_users';

   // protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    public function setPasswordAttribute($value){
        if(!empty($value)){
            $this->attributes['password'] = Hash::make($value);
        }
    }


}
