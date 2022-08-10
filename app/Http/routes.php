<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('/account',  ['middleware' => 'auth', 'uses' => 'AccountController@index']);

//Route::get('/step/{step}', ['middleware' => 'step', 'uses' => 'StepsController@show']);

//Route::post('/objectives', 'StepsController@getObjectives');

//Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


// HOME PAGE ===================================
// we dont need to use Laravel Blade
// we will return a PHP file that will hold all of our Angular content
// see the "Where to Place Angular Files" below to see ideas on how to structure your app return


//Route::get('/step/1', function(){ return view('layouts.app'); });

// API ROUTES ==================================
Route::group(array('prefix' => 'api'), function() {

    // since we will be using this just for CRUD, we won't need create and edit
    // Angular will handle both of those forms
    // this ensures that a user can't access api/create or api/edit when there's nothing there
   Route::post('/objectives', 'StepsController@getObjectives');

   Route::post('/interests', 'StepsController@getInterests');

   Route::post('/save_campaing', 'StepsController@saveCampaign');

   Route::post('/plans', 'StepsController@getPlans');

   Route::any('/upload_images', 'StepsController@uploadImages');

   Route::post('/auth/register', 'Auth\AuthController@register');

   Route::post('/auth/update_user', 'Auth\AuthController@update_user');
   
   Route::post('/auth/user', 'Auth\AuthController@user');
   Route::post('/auth/user_invoices', 'Auth\AuthController@user_invoices');

   Route::post('/auth/login', 'Auth\AuthController@login');

   Route::post('/auth/check', 'Auth\AuthController@check');

   Route::post('/auth/logout', 'Auth\AuthController@logout');

   Route::post('/auth/forgot_pass', 'Auth\AuthController@forgot_pass');

   Route::post('/contactus', 'Auth\AuthController@contactus');

   Route::post('/test', 'CompaignController@CompaignSaveParams');

   Route::post('/upload', 'CompaignController@Upload');

   Route::post('/pay', 'StepsController@pay');

   Route::post('/save_in_db', 'StepsController@save_user_info_in_db');

   Route::post('/check_is_used_coupon', 'StepsController@check_is_used_coupon');
});



Route::get('/', function() {
    return view('layouts.app');
});

Route::get('/auth/login_remote_{auth}', 'Auth\AuthController@login_remote');
Route::get('/auth/remote_data_{auth}', 'Auth\AuthController@login_remote_data');
Route::get('/mail/confirm', 'Auth\AuthController@mail_confirm');
Route::get('/mail/registration', 'Auth\AuthController@mail_registration');
Route::get('/mail/cart', 'Auth\AuthController@mail_cart');

Route::post('/admin/check', 'AdminAuthenticateController@check');