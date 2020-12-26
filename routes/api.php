<?php

//Auth Routes For Admin Dashboard
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function (){

    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth:api'], function (){

        Route::post('logout', 'LogOutController');

        Route::get('me', 'MeController');
    });

});

// Ecommerce Main Layouts Routes For Customers

// Customers Auth Routes

// DashBoard Routes
Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function (){

    //Category Routes
    Route::get('category', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::get('category/edit/{id}', 'CategoryController@edit');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::delete('category/destroy/{id}', 'CategoryController@destroy');
});