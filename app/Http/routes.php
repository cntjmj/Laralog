<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
    
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function() {
        return redirect()->route('home');
    });

    Route::get('h0me', 'HomeController@indeks')->name('h0me');
    Route::get('test', 'HomeController@test')->name('test');
    Route::get('home/{category_id?}', 'HomeController@index')->name('home');
    
    Route::get('news', 'ApiController@newsList')->name('newsList')->prefix('api');
    Route::get('category/{category_id}/news', 'ApiController@newsList')->name('newsListByCategory')->prefix('api');
});


	
