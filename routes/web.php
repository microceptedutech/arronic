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
Route::get('/create_post',function(){
	return view('createpost');
});
Route::post('/create_post/store','BlogController@store')->name('post.create');
Route::get('/post/load','BlogController@loadBlogs');
Route::post('/post/delete','BlogController@destroy');
Route::post('/create_post/update','BlogController@update');
Route::get('/sells','BlogController@sells');
Route::post('/sale/store','BlogController@insertData');
Route::get('/sales/load','BlogController@loadSales');
Route::post('/sale/delete','BlogController@deleteSale');
Route::get('/sales/topfives','BlogController@loadTopFives');

