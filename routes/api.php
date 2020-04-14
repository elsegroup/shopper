<?php

use Illuminate\Http\Request;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group([
        'as' => 'api.',
        'namespace' => 'Api\v1',
    ], function () {
        Route::group([
            'prefix' => 'products'
        ], function () {
            Route::get('/', 'ProductsController@index')->name('index');
            Route::get('/{product}', 'ProductsController@getProductById')->name('show');

            /*
                Route::post('/', 'ProductsController@store')->name('store');
                Route::put('/{id}', 'ProductsController@update')->name('update');
                Route::delete('/{id}', 'ProductsController@destroy')->name('destroy');
            */
        });

        Route::group([
            'prefix' => 'categories'
        ], function () {
            Route::get('/', 'CategoriesController@index')->name('index');
            Route::get('/{catalog}', 'CategoriesController@getCategory');
        });

        /* Route::group([
            'prefix' => 'cart'
        ], function () {
            Route::group(['prefix' => 'cart-item'], function () {
                Route::get('/', 'CartItemController@index')->name('index');
                Route::post('/', 'CartItemController@store')->name('store');
                Route::put('/{id}', 'CartItemController@update')->name('update');
                Route::delete('/{id}', 'CartItemController@destroy')->name('destroy');
            });
        }); */
});
