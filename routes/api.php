<?php

//Auth Routes For Admin Dashboard
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function (){

    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth:api'], function (){

        Route::post('logout', 'LogOutController');

        Route::get('me', 'MeController');
    });

    Route::post('forgetPassword', 'ForgetPasswordController@forgetPassword');

    Route::post('changePassword', 'ChangePasswordController@saveResetPassword');

});

// Customers Auth Routes

// Ecommerce Main Layouts Routes For Customers

// DashBoard Routes
Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function (){

    //Category Routes
    Route::get('category', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::get('category/edit/{id}', 'CategoryController@edit');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::delete('category/destroy/{id}', 'CategoryController@destroy');

    //Sub category Routes
    Route::get('sub_category', 'SubCategoryController@index');
    Route::post('sub_category/store', 'SubCategoryController@store');
    Route::get('sub_category/edit/{id}', 'SubCategoryController@edit');
    Route::post('sub_category/update/{id}', 'SubCategoryController@update');
    Route::delete('sub_category/destroy/{id}', 'SubCategoryController@destroy');

    //Brand Routes
    Route::get('brand', 'BrandController@index');
    Route::post('brand/store', 'BrandController@store');
    Route::get('brand/edit/{id}', 'BrandController@edit');
    Route::post('brand/update/{id}', 'BrandController@update');
    Route::delete('brand/destroy/{id}', 'BrandController@destroy');

    //Tag Routes
    Route::get('tag', 'TagController@index');
    Route::post('tag/store', 'TagController@store');
    Route::get('tag/edit/{id}', 'TagController@edit');
    Route::post('tag/update/{id}', 'TagController@update');
    Route::delete('tag/destroy/{id}', 'TagController@destroy');

    //product routes
});