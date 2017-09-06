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

Route::get('/advert/categories','MarketController@categories');
Route::get('/advert/all-categories','MarketController@getAllCategories');
Route::get('/error','MarketController@error');

Route::get('/advert/category/fields/{any}','MarketController@fields');

Route::post('/user/login', 'UserController@login');
Route::middleware('auth:api')->get('/user/adverts', 'UserController@adverts');
Route::get('/user/contacts','UserController@contacts')->middleware('auth:api');

Route::post('/user/paypal/nonce','UserController@nonce')->middleware('auth:api');
Route::get('/user/paypal/token','UserController@token')->middleware('auth:api');
Route::get('/user/cards','UserController@cards')->middleware('auth:api');
Route::post('/user/cards/add','UserController@addcard')->middleware('auth:api');
Route::post('/user/card/charge','UserController@charge')->middleware('auth:api');

Route::post('/user/dob/add','UserController@dob')->middleware('auth:api');
Route::post('/user/documents/identity','UserController@identity')->middleware('auth:api');
Route::post('/user/addresses/add','UserController@add_address')->middleware('auth:api');

Route::get('/user/addresses','UserController@addresses')->middleware('auth:api');
Route::post('/user/addresses/verify/{id}','UserController@verify_address')->middleware('auth:api');


Route::post('/user/bankaccounts/add','UserController@account')->middleware('auth:api');
Route::post('/user/terms/accept','UserController@terms')->middleware('auth:api');

Route::post('/user/balance/withdraw','UserController@withdraw')->middleware('auth:api');


Route::get('/user/account/info','UserController@info')->middleware('auth:api');
Route::get('/clients','MarketController@clients');

Route::post('/search', 'MarketController@query');

Route::post('/user/register', 'UserController@register');
Route::post('/user/advert/create','UserController@create')->middleware('auth:api');

Route::post('/user/advert/update','UserController@update')->middleware('auth:api');
Route::post('/user/advert/delete','UserController@delete')->middleware('auth:api');

Route::post('/user/cvs/add','UserController@addcv')->middleware('auth:api');
Route::post('/user/cvs/get','UserController@getcv')->middleware('auth:api');



Route::post('/user/covers/add','UserController@addcover')->middleware('auth:api');


Route::get('/user/advert/price','UserController@price')->middleware('auth:api');

Route::get('/user/advert/favorites','UserController@favorites')->middleware('auth:api');

Route::get('/user/text','UserController@text');

Route::get('/advert/{id}','MarketController@advert')->middleware('auth:api');


Route::post('/user/advert/mprice','UserController@mprice')->middleware('auth:api');

Route::post('/user/advert/order','UserController@order')->middleware('auth:api');

Route::post('/user/advert/offer','UserController@offer')->middleware('auth:api');
Route::post('/user/advert/interest','UserController@interest')->middleware('auth:api');
Route::post('/user/advert/favorite','UserController@favorite')->middleware('auth:api');
Route::post('/user/list/favorite','UserController@favorite')->middleware('auth');


Route::post('/user/advert/report','UserController@report')->middleware('auth:api');
Route::post('/user/order/review','UserController@review')->middleware('auth:api');

Route::post('/user/advert/apply','UserController@apply')->middleware('auth:api');


Route::post('/user/advert/ccreate','UserController@ccreate');

Route::get('/user/profile', 'UserController@profile')->middleware('auth:api');


Route::get('/user/adverts/transfer', 'UserController@transfer')->middleware('auth:api');

Route::post('/user/contract','UserController@contract')->middleware('auth:api');

Route::post('/user/advert/create/bump','UserController@bump')->middleware('auth:api');
Route::post('/user/advert/packs/buy','UserController@buy')->middleware('auth:api');

Route::post('/user/balance/topup','UserController@topup')->middleware('auth:api');

Route::get('/stripe', 'UserController@stripe');
Route::get('/suggest','MarketController@suggest');

Route::get('/train','MarketController@train');

Route::get('/{any}','MarketController@error');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
