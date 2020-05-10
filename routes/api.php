<?php

use Illuminate\Http\Request;

Route::group([
        'as' => 'api.',
        'namespace' => 'Api\v1',
    ], function () {
        Route::apiResource('products', 'ProductsController')->except(['update', 'store', 'destroy']);

        Route::apiResource('catalogs', 'CatalogsController')->except(['update', 'store', 'destroy']);

        Route::apiResource('carts', 'CartController')->except(['update', 'index']);

        Route::post('/carts/{cart}', 'CartController@addProducts');
        Route::post('/carts/{cart}/checkout', 'CartController@checkout');

        Route::get('pages/{page}', 'PageController');
});
