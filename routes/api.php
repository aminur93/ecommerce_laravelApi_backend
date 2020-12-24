<?php

//Auth Routes For Admin Dashboard
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function (){

    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth:api'], function (){

        Route::post('logout', 'LogOutController');

        Route::get('me', 'MeController');
    });


});