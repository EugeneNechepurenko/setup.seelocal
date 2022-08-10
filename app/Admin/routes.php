<?php

Route::get('', ['as' => 'admin.dashboard', function () {
	$content = '';
	return AdminSection::view($content, 'Dashboard');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);
Route::get('exit', ['as' => 'admin.exit', function () {
	Cookie::queue('user_id', '');
            Cookie::queue('hash_id', '');
     return redirect('admin')->with('status', 'error!');
}]);

//Route::get('ordera', ['as' => 'admin.ordera', 'uses' => 'AdminController@getCampaign', function () {
Route::get('ordera', ['as' => 'admin.ordera', 'App\Http\Controllers\AdminController@getCampaign', function () {

	return AdminSection::view('', 'ordera');
}]);
