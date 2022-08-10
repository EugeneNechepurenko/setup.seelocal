<?php

namespace App;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'user_management';

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company_name',
        'password',
        'phone_number',
        'status',
        'url'
    ];
public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
//    protected $hidden = [
//        'password'
//    ];
//
//    protected $casts = [
//       'status' => 'boolean'
//    ];

//    public function setPasswordAttribute($value){
//        if(!empty($value)){
//            $this->attributes['password'] = Hash::make($value);
//        }
//    }

    public function setPasswordAttribute($value){
        if(!empty($value)) {
            $key = 'abcd5435423aderst';
            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
            $this->attributes['password'] = $encrypted;
        }
    }

}
