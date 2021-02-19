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

// E-commerce Main Layouts Routes For Customers

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

    //product routes colors and sizes and stock etc...

    /*color routes*/
    Route::get('color', 'ColorController@index');
    Route::post('color/store', 'ColorController@store');
    Route::get('color/edit/{id}', 'ColorController@edit');
    Route::post('color/update/{id}', 'ColorController@update');
    Route::delete('color/destroy/{id}', 'ColorController@destroy');
    /*color routes*/

    /*Size Routes*/
    Route::get('size', 'SizeController@index');
    Route::post('size/store', 'SizeController@store');
    Route::get('size/edit/{id}', 'SizeController@edit');
    Route::post('size/update/{id}', 'SizeController@update');
    Route::delete('size/destroy/{id}', 'SizeController@destroy');
    /*Size Routes*/

    /*Origin Routes*/
    Route::get('origin', 'OriginController@index');
    Route::post('origin/store', 'OriginController@store');
    Route::get('origin/edit/{id}', 'OriginController@edit');
    Route::post('origin/update/{id}', 'OriginController@update');
    Route::delete('origin/destroy/{id}', 'OriginController@destroy');
    /*Origin Routes*/

    /*Material Routes*/
    Route::get('material', 'MaterialController@index');
    Route::post('material/store', 'MaterialController@store');
    Route::get('material/edit/{id}', 'MaterialController@edit');
    Route::post('material/update/{id}', 'MaterialController@update');
    Route::delete('material/destroy/{id}', 'MaterialController@destroy');
    /*Material Routes*/

    /*Product Routes*/
    Route::get('product','ProductController@index');
    Route::post('product/store','ProductController@store');
    Route::get('product/edit/{id}','ProductController@edit');
    Route::post('product/update/{id}','ProductController@update');
    Route::delete('product/destroy/{id}','ProductController@destroy');

    Route::get('product/getSubCategory/{category_id}','ProductController@getSubCategories');
    Route::post('product/feature/{product_id}','ProductController@feature');
    /*Product Routes*/

    //product routes colors and sizes and stock etc...
});