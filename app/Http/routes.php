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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

/* sign up page */
Route::get('/signup', 'UsersController@create')->name('signup');

Route::resource('/users', 'UsersController');
//above codes equals to the following
/*
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
*/

//login and logout routes
Route::get('/login', 'SessionsController@create')->name('login');//get login page
Route::post('/login', 'SessionsController@store')->name('login');//build login session
Route::delete('/logout', 'SessionsController@destroy')->name('logout');//logout

//user activation
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//password reset
Route::get('password/email', 'Auth\PasswordController@getEmail')->name('password.reset');//get page of password-reset-email-send page
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('password.reset');//operation of send reset email
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('password.edit');//page of set new password
Route::post('password/reset', 'Auth\PasswordController@postReset')->name('password.update');//operation of send password reset request

//statuses operation
resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
