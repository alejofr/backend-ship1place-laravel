<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function() { 

    Route::post('/logout', 'App\Http\Controllers\Auth\LogoutController@logout');

    // create user sub client
    Route::post('/users/register-sub-client', 'App\Http\Controllers\UserController@storeSubClient')->middleware('validClient');

    // update user
    Route::put('/users/{user}', 'App\Http\Controllers\UserController@update');

    // delete user
    Route::delete('/users/{user}', 'App\Http\Controllers\UserController@destroy');

    //disable
    Route::put('/users/{user}/disable', 'App\Http\Controllers\UserController@disableUser');

    Route::middleware('validAdmin')->group(function() { 
        // users
        Route::get('/users', 'App\Http\Controllers\UserController@index');
    });

    //change password
    Route::post('/user/change-password', 'App\Http\Controllers\UserController@changePassword');

    //current logs
    Route::get('current-logs', 'App\Http\Controllers\LogController@allCurrent');

    // history logs
    Route::get('history-logs', 'App\Http\Controllers\LogController@historyLogs');
});



Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/user/recover-password', 'App\Http\Controllers\UserController@recoverPassword');

//countries
Route::resource('/countries', 'App\Http\Controllers\CountryController');
//provinces
Route::resource('/provinces', 'App\Http\Controllers\ProvinceController');
//cities
Route::resource('/cities', 'App\Http\Controllers\CityController');

// search user
Route::get('/user/search', 'App\Http\Controllers\UserController@search');
// search country
Route::get('/country/search', 'App\Http\Controllers\CountryController@search');
// search province
Route::get('/province/search', 'App\Http\Controllers\ProvinceController@search');
// search city
Route::get('/city/search', 'App\Http\Controllers\CityController@search');