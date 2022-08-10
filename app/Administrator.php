<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'admin_users';

    protected $fillable = ['name', 'email', 'password', 'status'];

    protected $dates = ['createdDate', 'modifiedDate'];

    protected $hidden = ['password', 'sha_key'];



//$key = 'abcd5435423aderst';
//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $_POST['password'], MCRYPT_MODE_CBC, md5(md5($key))));
    public function setPasswordAttribute($value){
        if(!empty($value)) {
            $key = 'abcd5435423aderst';
            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
            $this->attributes['password'] = $encrypted;
        }
    }






}
