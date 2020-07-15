<?php
use Illuminate\Http\Request;

Route::group([
        'as' => 'api.',
        'namespace' => 'Api\v1',
        'middleware' => ['api']
    ], function () {
        Route::apiResource('products', 'ProductsController')->except(['update', 'store', 'destroy']);
        Route::apiResource('catalogs', 'CatalogsController')->except(['update', 'store', 'destroy']);
        Route::post('checkout', 'CartController@checkout');
        Route::get('pages/{page}', 'PageController');
});
