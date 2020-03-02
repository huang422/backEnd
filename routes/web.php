<?php

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

Route::get('/', 'FrontController@index');

Route::get('/news', 'FrontController@news');

Route::get('/product', 'FrontController@product');

// Route::get('/product', function () {
//     return view('front/product');
// });

Auth::routes();





Route::group(['middleware' => ['auth']], function () {
    //首頁
    Route::get('/home', 'HomeController@index')->name('home');

    //最新消息
    Route::get('/home/news', 'NewsController@index');
    Route::post('/home/news/store', 'NewsController@store');

    //product
    Route::get('/home/product', 'ProductController@index');
    Route::post('/home/product/store','ProductController@store');

});
