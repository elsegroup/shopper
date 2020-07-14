<?php
use Illuminate\Http\Request;

Route::group([
        'as' => 'api.',
        'namespace' => 'Api\v1',
        'middleware' => ['cors', 'api']
    ], function () {
        Route::apiResource('products', 'ProductsController')->except(['update', 'store', 'destroy']);
        Route::apiResource('catalogs', 'CatalogsController')->except(['update', 'store', 'destroy']);
        // Route::apiResource('carts', 'CartController')->except(['update', 'index']);
        // Route::post('/carts/{cart}', 'CartController@addProducts');
        Route::post('checkout', 'CartController@checkout');
        Route::get('pages/{page}', 'PageController');
});
