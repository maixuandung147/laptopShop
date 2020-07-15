<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'admin','middleware'=>'adminMiddleware'],function(){
	Route::resource('home','Admin\HomeController');
	Route::get('category/fetch_data','Admin\CateController@fetch_data');
	Route::resource('category','Admin\CateController');

	Route::get('product/fetch_data','Admin\ProductController@fetch_data');
	Route::get('product/like/{id}','Admin\ProductController@like')->name('product.like');
	Route::post('images/{id}', 'Admin\ProductController@image')->name('post.image');
	Route::resource('product','Admin\ProductController');

	Route::resource('image','Admin\ImagesController');

	Route::get('user/fetch_data','Admin\UserController@fetch_data');
	Route::resource('user','Admin\UserController');

	Route::get('suggest/fetch_data','Admin\SuggestController@fetch_data');
	Route::resource('suggest','Admin\SuggestController');

	Route::get('order/fetch_data','Admin\OrderController@fetch_data');
	Route::resource('order','Admin\OrderController');

	Route::get('promotion/fetch_data','Admin\PromotionController@fetch_data');
	Route::get('promotion/ajax/{idSup}','Admin\PromotionController@ajax');
	Route::resource('promotion','Admin\PromotionController');
});


// USER
Route::get('/', 'User\ProductController@index')->name('home');
Route::get('/product', 'User\ProductController@getAllProduct')->name('list-product');
Route::get('/suggest', 'User\SuggestController@create')->name('create-suggest');
Route::get('suggest/ajax/{idCate}','User\SuggestController@ajax');
Route::post('suggest', 'User\SuggestController@store')->name('store-suggest');
Route::get('/product/fetch_data','User\ProductController@fetch_data');
Route::get('/feature', 'User\ProductController@getFeature')->name('list-feature');
Route::get('/feature/fetch_data','User\ProductController@feature');
Route::get('/highlight', 'User\ProductController@getHighlight')->name('list-highlight');
Route::get('/highlight/fetch_data','User\ProductController@highlight');
Route::get('/category/{id}', 'User\CategoryController@index')->name('list-category');
Route::get('/category/{id}/fetch_data', 'User\CategoryController@fetch_data');
Route::get('/category/cateRequest/{id}', 'User\CategoryController@cateRequest')->name('cateRequest'); 
Route::get('/category/cateRequest/{id}/fetch_data', 'User\CategoryController@fetch_data'); 
Route::get('search', 'User\ProductController@search')->name('search-product');
Route::get('/preview/{id}', 'User\ProductController@show')->name('preview');
Route::get('/register', 'User\UserController@index')->name('register');
Route::post('/register', 'User\UserController@store');
Route::get('/login', 'User\UserController@getLogin')->name('login');
Route::post('/login', 'User\UserController@setLogin');


Route::get('/my-account/{id}', 'User\UserController@show')->name('user');
Route::get('/my-account/account-information/{id}', 'User\UserController@edit')->name('information-user');
Route::get('/suggest-user/{id}', 'User\UserController@suggest_user')->name('suggest-user');
Route::put('/my-account/account-information/{id}/account-update/', 'User\UserController@update')->name('update-user');
Route::get('/my-account/change-password/{id}', 'User\UserController@change_password')->name('change-password');
Route::put('/my-account/change-password/{id}/password-update/', 'User\UserController@pass_updatae')->name('password-update');
Route::get('/order-user/{id}', 'User\UserController@order_user')->name('order-user');
Route::get('/product-user/{id}', 'User\UserController@product_user')->name('product-user');
Route::get('logout', 'User\UserController@logOut')->name('logout');


Route::group(['prefix'=>'card'], function(){
	Route::get('/index', 'User\CartController@index')->name('cart-index');
	Route::get('/add-cart/{id}', 'User\CartController@addCart')->name('add-cart');
	Route::get('/update', 'User\CartController@getUpdateCart')->name('update-cart');
	Route::get('/delete-cart/{id}', 'User\CartController@destroy')->name('delete-cart');
	Route::get('/checkout', 'User\CheckoutController@index')->name('checkout');
	Route::post('/checkout', 'User\CheckoutController@store')->name('add-order');
});

Route::group(['prefix'=>'ajax'], function(){
	Route::post('/rating/{id}', 'User\RatingController@saveRating')->name('save-rating');
});