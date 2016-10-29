<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::post('/login', 'Controller@login');
Route::group(['middleware' => 'api_key'], function () {
    Route::get('/', 'Controller@index');
    Route::get('/expenses/{id?}', 'Controller@expenses');
    Route::get('/deleteExpense/{id}', 'Controller@deleteExpense');
    Route::get('/total', 'Controller@total');
    Route::post('/addExpense', 'Controller@addExpense');
});
