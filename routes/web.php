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
Route::get('/news/{id}', 'FrontController@news_detail');

Route::get('/contact', 'FrontController@contact');
Route::post('/contact_store', 'FrontController@contact_store');

Route::get('/product', 'FrontController@product');
Route::get('/product/{product_id}', 'FrontController@product_detail');

Route::post('/add_cart/{product_id}', 'FrontController@add_cart'); //加入購物車
Route::post('/update_cart/{product_id}', 'FrontController@update_cart'); //更新購物車數量
Route::post('/delete_cart/{product_id}', 'FrontController@delete_cart'); // 刪除商品於購物車

Route::get('/cart', 'FrontController@total_cart'); //cart總攬
Route::get('/cart_checkout', 'FrontController@cart_checkout'); //cart結帳
Route::post('/cart_checkout', 'FrontController@post_cart_checkout'); //cart結帳

Route::get('/test_check_out', 'FrontController@test_check_out');


Route::prefix('cart_ecpay')->group(function(){

    //當消費者付款完成後，綠界會將付款結果參數以幕後(Server POST)回傳到該網址。
    Route::post('notify', 'FrontController@notifyUrl')->name('notify');

    //付款完成後，綠界會將付款結果參數以幕前(Client POST)回傳到該網址
    Route::post('return', 'FrontController@returnUrl')->name('return');
});








Auth::routes();


Route::group(['middleware' => ['auth'],"prefix" => '/home'], function () {
    //首頁
    Route::get('/', 'HomeController@index')->name('home');

    //最新消息
    Route::get('/news', 'NewsController@index');
    Route::get('/news/create', 'NewsController@create');
    Route::post('/news/store', 'NewsController@store');
    Route::get('/news/edit/{id}', 'NewsController@edit');
    Route::post('/news/update/{id}', 'NewsController@update');
    Route::post('/news/delete/{id}', 'NewsController@delete');

    Route::post('ajax_delete_news_imgs', 'NewsController@ajax_delete_news_imgs');
    Route::post('ajax_post_sort', 'NewsController@ajax_post_sort');

    Route::post('/ajax_upload_img','UploadImgController@ajax_upload_img');
    Route::post('/ajax_delete_img','UploadImgController@ajax_delete_img');



    //product
    Route::get('/product', 'ProductController@index');
    Route::get('/product/create', 'ProductController@create');
    Route::post('/product/store', 'ProductController@store');
    Route::get('/product/edit/{id}', 'ProductController@edit');
    Route::post('/product/update/{id}', 'ProductController@update');
    Route::post('/product/delete/{id}', 'ProductController@delete');

    //productTypes
    Route::get('/productTypes', 'ProductTypesController@index');
    Route::get('/productTypes/create', 'ProductTypesController@create');
    Route::post('/productTypes/store', 'ProductTypesController@store');
    Route::get('/productTypes/edit/{id}', 'ProductTypesController@edit');
    Route::post('/productTypes/update/{id}', 'ProductTypesController@update');
    Route::post('/productTypes/delete/{id}', 'ProductTypesController@delete');

    //contact
    Route::get('/contact', 'ContactController@index');
    Route::post('/contact/delete/{id}', 'ContactController@delete');

});
