<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Blade;
use Cookie;
use DB;
use Hash;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_id = Cookie::get('user_id');
        $hash_id = Cookie::get('hash_id');
        if (!empty($user_id) && !empty($hash_id)) {
               $admin_user = DB::table('admin_users')->where('id', $user_id)->first();
               if(!empty($admin_user)){
                    $hash = md5($admin_user->email.$user_id);
                    if($hash == $admin_user->sha_key){
                       return $next($request);
                    }
               }else{
                    echo view('admin.admin');
                    exit;
               }
                echo view('admin.admin');
                exit;
        }else{
            echo view('admin.admin');
            exit;
        }

        return $next($request);
    }
}