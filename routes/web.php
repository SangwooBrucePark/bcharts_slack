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
    return view('realwelcome');
});


Route::get('/v1/auth', 'AuthorizingController@auth');

Route::post('/v1/bcharts', 'CommandAnalyzer@bcharts');

Route::post('/v1/interactive', 'InteractionController@interactive');