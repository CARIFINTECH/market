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
Route::get('/dummy', 'MarketController@dummy');
Route::get('/pull', 'MarketController@pull');
Route::get('/ufields', 'MarketController@ufields');
Route::get('/loc', 'MarketController@loc');
Route::get('/locs', 'MarketController@locs');
Route::get('/wrong', 'MarketController@wrong');
Route::get('/searchform', 'MarketController@searchform');
Route::get('/gads', 'MarketController@gads');
Route::get('/allfields', 'MarketController@allfields');

Route::get('/ast/{p}/{q}', 'MarketController@ast');

Route::post('/hellosign', 'MarketController@hellosign');

Route::get('/update', 'MarketController@update');
Route::get('/updates', 'MarketController@updates');

Route::get('/insert', 'MarketController@insert');
Route::get('/user/ads/post', 'HomeController@post');
Route::post('/user/advert/location', 'HomeController@location');
Route::post('/user/advert/newad', 'HomeController@newad');
Route::get('/user/manage/ads', 'BusinessController@myads');

Route::post('/user/advert/category/change', 'HomeController@change_category');
Route::post('/user/advert/location/change', 'HomeController@change_location');


Route::get('/user/ad/create', 'HomeController@create');
Route::get('/user/manage/ad/{id}', 'HomeController@manage');

Route::get('/userads/{id}', 'MarketController@userads');

Route::get('/user/manage/messages', 'MessageController@messages');
Route::get('/user/manage/messages/{rid}', 'MessageController@gmessages');

Route::post('/user/message/send','MessageController@send');
Route::post('/user/message/rsend','MessageController@rsend');

Route::get('/user/manage/favorites', 'HomeController@favorites');
Route::get('/user/manage/alerts', 'HomeController@alerts');
Route::get('/user/create/alert/{id}', 'HomeController@alert');
Route::get('/user/delete/alert/{id}', 'HomeController@delete_alert');

Route::post('/user/cards/add', 'HomeController@addcard');
Route::get('/user/manage/order', 'HomeController@order');
Route::get('/user/address/change/{id}', 'HomeController@change');
Route::get('/user/manage/order/shipping/update/{id}', 'HomeController@update_shipping');
Route::get('/user/generate/pdf', 'HomeController@pdf');


Route::get('/business/manage/ads', 'BusinessController@myads');
Route::get('/business/manage/finance', 'BusinessController@finance');
Route::get('/business/manage/details', 'BusinessController@details');
Route::get('/business/manage/company', 'BusinessController@company');
Route::get('/business/manage/metrics', 'BusinessController@metrics');
Route::get('/business/manage/support', 'BusinessController@support');

Route::post('/business/manage/bump', 'BusinessController@bump');

Route::get('/business/invoice/pay/{id}', 'BusinessController@invoice');

Route::get('/user/reply/{id}', 'MessageController@reply');


Route::get('/user/manage/orders', 'HomeController@orders');
Route::get('/user/manage/buying', 'HomeController@buying');
Route::get('/user/manage/details', 'HomeController@details');

Route::get('/user/manage/shipping/{id}', 'HomeController@shipping');

Route::get('/user/contract/pricing', 'HomeController@pricing');
Route::get('/user/contract/business/{id}', 'HomeController@business');
Route::get('/user/contract/cbusiness', 'HomeController@cbusiness');

Route::get('/user/contract/start', 'HomeController@contract');
Route::get('/user/contract/sign', 'HomeController@sign');
Route::get('/user/contract/pack/delete/{id}', 'HomeController@delete_pack');

Route::get('/user/contract/pack/{category}/{location}', 'HomeController@pack');
Route::get('/user/contract/packs', 'HomeController@packs');


Route::post('/user/payment/stripe', 'HomeController@stripe');
Route::get('/user/payment/paypal', 'HomeController@paypal');

Route::get('/user/email/verify', 'HomeController@verify');
Route::post('/user/list/favorite','UserController@favorite')->middleware('auth');
Route::post('/user/list/unfavorite','UserController@unfavorite')->middleware('auth');
Route::get('/user/list/price','UserController@price')->middleware('auth');

Route::get('/user/advert/delete/{id}', 'HomeController@delete');
Route::get('/user/advert/repost/{id}', 'HomeController@repost');
Route::get('/user/advert/edit/{id}', 'HomeController@edit');

Route::get('/user/advert/duplicate/{id}', 'HomeController@duplicate');

Route::post('/user/advert/save', 'HomeController@save');

Route::get('/user/p/stats/{id}', 'HomeController@stats');


Route::get('/category/children/{id}', 'HomeController@children');
Route::get('/location/children/{id}', 'HomeController@lchildren');
Route::get('/postcodes/postcode', 'HomeController@postcode');

Route::get('/category/extras/{id}', 'HomeController@extras');
Route::get('/category/prices/{id}', 'HomeController@prices');
Route::get('/category/price/{id}', 'HomeController@price');

Route::get('/category/total/{id}', 'HomeController@total');
Route::get('/product/total', 'HomeController@ad_total');


Route::get('/category/suggest', 'HomeController@suggest');
Route::get('/category/string/{id}', 'HomeController@string');
Route::get('/location/string/{id}', 'HomeController@lstring');

Route::get('/fields/{any}', 'MarketController@fields');
Route::get('/filters/{any}', 'MarketController@filters');

Route::get('/id/{id}', 'MarketController@id');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes();

Route::get('/jobscats', 'MarketController@jobscats');
Route::get('/notfound', 'MarketController@notfound');

Route::get('/', 'MarketController@index');
Route::get('/user/leaves','MarketController@leaves');

Route::get('/p/{cat}/{id}', 'MarketController@product');

Route::get('/{any}', 'MarketController@search');
Route::get('/{any}/{loc}', 'MarketController@lsearch');
Route::namespace('Admin')->group(function () {
    Route::post('/admin/manage/pricegroup/add', 'AdminController@add_pricegroup')->middleware('admin');
    Route::get('/admin/manage/pricegroup/edit/{id}', 'AdminController@edit_pricegroup')->middleware('admin');
    Route::get('/admin/manage/pricegroup/delete/{id}', 'AdminController@delete_pricegroup')->middleware('admin');
    Route::get('/admin/manage/packs', 'AdminController@packs')->middleware('admin');
    Route::get('/admin/manage/pricegroup', 'AdminController@pricegroup')->middleware('admin');
    Route::get('/admin/manage/role', 'AdminController@iam')->middleware('admin');
});