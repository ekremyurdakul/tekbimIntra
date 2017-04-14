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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/hpeData', 'HPEDataController@index');

Route::get('/stock', 'StockController@index');
Route::get('/stock/lobby/{id}', 'StockController@lobby');
Route::get('/stock/lobby/join/{id}', 'StockController@join');
Route::get('/stock/lobby/display/{id}', 'StockController@display');
Route::get('/stock/data/{id}', 'StockController@getData');
Route::get('/stock/data/', 'StockController@getQuantity');
Route::post('/stock/add', 'StockController@add');
Route::post('/stock/lobby/addGroup', 'StockController@addGroup');
Route::post('/stock/finish', 'StockController@finish');
Route::post('/stock/searchByProductCode', 'StockController@searchByProductCode');
Route::post('/stock/searchByEanCode', 'StockController@searchByEanCode');
Route::post('/stock/saveProduct', 'StockController@saveProduct');


Route::get('/market', 'MarketController@index');
Route::get('/market/lookupPrice/{id}', 'MarketController@lookupPrice');

Route::get('/employee', 'EmployeeController@index');
Route::post('/employee/aedit', 'EmployeeController@edit');

Route::get('/service', 'ServiceController@index');
Route::get('/service/accept', 'ServiceController@accept');
Route::get('/service/current', 'ServiceController@current');
Route::get('/service/aedit/technic', 'ServiceController@technic');
Route::get('/service/aedit/technic/serialneed/{id}', 'ServiceController@snoNeeded');
Route::get('/service/aedit/technic/product/{id}', 'ServiceController@product');
Route::post('/service/register', 'ServiceController@register');
Route::post('/service/aedit/technic', 'ServiceController@technician');
Route::post('/service/aedit/technic/statusChange', 'ServiceController@statusChange');
Route::post('/service/aedit/technic/addOperation', 'ServiceController@addOperation');
Route::post('/service/aedit/technic/deleteProduct', 'ServiceController@deleteProduct');
Route::post('/service/aedit/technic/deleteOperation', 'ServiceController@deleteOperation');


Route::get('/stock/test/{ean}', 'StockController@test');

Route::get('/customer/search/{search}', 'CustomerController@search');
Route::get('/customer/search/', 'CustomerController@emptySearch');
Route::post('/customer/register/', 'CustomerController@register');