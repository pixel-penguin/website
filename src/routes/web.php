<?php

Route::group([
	'namespace' => 'PixelPenguin\Website\Http\Controllers',
	'middleware' => ['web']
], function(){
	
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	Route::post('/subscribe-news-letter', 'HomeController@SubscribeNewsLetter');
	//Route::get('demo', 'DemoController@index');
	
	Route::get('/product/{linkName}', 'ProductController@index');
	Route::get('/products/{categoryId?}/{orderBy?}', 'ProductController@directory');
	
	Route::get('/cart/view', 'CartController@viewCart');
	Route::get('/contact-us', 'ContactController@index');
	
	
    Route::get('/page/{linkName}', 'PageController@index')->name('pageView');
    Route::get('/invoice/{referenceCode}', 'InvoiceController@index')->name('pageView');
	
	
    Route::get('/thankyou/{referenceCode}', 'InvoiceController@thankYou')->name('pageView');
	//Route::post('add-to-cart', 'CartController@addToCart');
	
	Route::get('/json/products/get/{categoryId?}/{take?}/{skip?}/{orderBy?}/{orderType?}', 'ProductController@jsonDirectory');
});

Route::group([
	'namespace' => 'PixelPenguin\Website\Http\Controllers',
	'middleware' => ['web'],
    'prefix'     	=> 	'cart',
], function(){
	
	Route::post('add', 'CartController@addToCart');
	Route::post('update', 'CartController@updateCart');
	Route::get('get', 'CartController@getCart');
	Route::post('remove', 'CartController@removeItemCompletely');
	
	Route::post('clear', 'CartController@clearCart');
});

Route::group([
	'namespace' => 'PixelPenguin\Website\Http\Controllers',
	'middleware'	=>	['web', 'auth'],

	], function () {
	
	Route::get('/checkout', 'CartController@viewCheckout');

});
