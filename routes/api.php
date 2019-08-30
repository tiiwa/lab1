<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@authenticate');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/check', 'AuthController@check');
    Route::post('/register', 'AuthController@register');
    Route::get('/activate/{token}', 'AuthController@activate');
    Route::post('/password', 'AuthController@password');
    Route::post('/validate-password-reset', 'AuthController@validatePasswordReset');
    Route::post('/reset', 'AuthController@reset');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/auth/user', 'AuthController@getAuthUser');
    Route::resource('/user', 'UserController@index');
    Route::post('/user/change-password', 'AuthController@changePassword');
    Route::post('/user/update-profile', 'UserController@updateProfile');
    Route::post('/user/update-avatar', 'UserController@updateAvatar');
    Route::post('/user/remove-avatar', 'UserController@removeAvatar');
    Route::delete('/user/{id}', 'UserController@destroy');
});

Route::get('/search', 'OrganizationController@search');
Route::post('/search', 'OrganizationController@filter');
Route::get('/org/all', 'OrganizationController@indexAll');
Route::get('/org/{id}/approve', 'OrganizationController@approveOrganization');
Route::get('/org/{id}/disapprove', 'OrganizationController@disapproveOrganization');
Route::resource('org', 'OrganizationController');

// Home
Route::get('home', 'HomeController@index')->name('home');
