<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Illuminate\Http\Request;
use Cookie;
use Illuminate\Routing\Controller;
use Response;

class AdminAuthenticateController extends Controller
{

    public function __construct(){
    }

    public function check(){
        $admin_users = DB::table('admin_users')->get();
        $admin_users1 = array();
        $n = sizeof($admin_users);
        for($i=0;$i<$n;++$i){
            $admin_users1[] = (array) $admin_users[$i];
        }
        $admin_users = $admin_users1;
        $check_email = array_search($_POST['email'], array_column($admin_users, 'email'));


        $key = 'abcd5435423aderst';
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $_POST['password'], MCRYPT_MODE_CBC, md5(md5($key))));

        if($check_email != false){

            foreach ($admin_users as $value) {
               if($value['email'] == $_POST['email']){


                    if($encrypted == $value['password']){
                        // Update. 
                        $sha_key = md5($_POST['email'].$value['id']);
                        DB::table('admin_users')->where('id', $value['id'])->update(['sha_key' => $sha_key]);
                        Cookie::queue('user_id', $value['id']);
                        Cookie::queue('hash_id', $sha_key);
                        return redirect('admin')->with('status', 'ok!');
                    }else{
                        Cookie::queue('user_id', '');
                        Cookie::queue('hash_id', '');
                        return redirect('admin')->with('status', 'error!');
                    }
               }
            }
        }else{
            Cookie::queue('user_id', '');
            Cookie::queue('hash_id', '');
            return redirect('admin')->with('status', 'error!');
        }
    }
}
