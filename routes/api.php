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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
	Route::get('/', 'ApiDocController');

    // toggle apis
	Route::get('/{table_name}/{id}/toggle-on-showing', 'InnerQueriesController@toggleOnShowing');
	Route::get('/{table_name}/{id}/toggle-is-recommended', 'InnerQueriesController@toggleIsRecommended');
	Route::get('/{table_name}/{id}/toggle-is-done', 'InnerQueriesController@toggleIsDone');

	// inner index apis
	// Route::get('/home-data', 'HomepageConfigController@indexData');

	// Route::get('/products-data', 'InnerQueriesController@productsData');
	// Route::delete('/products/{id}', 'ProductsController@destroy');

	// Route::get('/news-data', 'InnerQueriesController@newsData');
	// Route::get('/news-en-data', 'InnerQueriesController@newsData');

	// outer apis
	// Route::get('/get-homepage-data', 'HomepageConfigController@indexData');

	// Route::get('/get-product-nav', 'ProductsController@getNav');
	// Route::get('/get-product-list', 'ProductsController@getList');
	// Route::get('/get-product-data', 'ProductsController@getData');

	// Route::get('/get-news-list', 'NewsController@getList');
	// Route::get('/get-news-data', 'NewsController@getData');

	// Route::get('/get-warranty-product-categories-list', 'WarrantiesController@getList');
	// Route::post('/post-store-warranty-data', 'WarrantiesController@postStoreData');

	// Route::post('/post-store-contact-data', 'ContactsController@postStoreData');
});