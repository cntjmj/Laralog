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
    Route::post('/b4login', 'Auth\AuthController@b4login');

    Route::get('/', function() {
        return redirect()->route('homeIndex');
    });

    Route::get('h0me', 'HomeController@indeks')->name('h0me');
    Route::get('test', 'HomeController@test')->name('test');
    Route::get('home/{category_id?}', 'HomeController@index')->name('homeIndex'); 
    Route::get('news/{news_id}', 'HomeController@news')->name('homeNews');
    
    Route::get('user/profile/{user_id}', 'UserController@viewProfile')->name('userViewProfile');
    Route::put('user/profile/{user_id}', 'UserController@updateProfile')->name('userUpdateProfile');
    
    Route::get('api/news', 'ApiController@getNewsList')->name('apiGetNewsList');
    Route::get('api/category/{category_id}/news', 'ApiController@getNewsList')->name('apiGetNewsListByCategory');
    Route::get('api/user/{user_id}', 'ApiController@getUser')->name('apiGetUserByID');
    
    Route::post('api/news/{news_id}/comment', 'ApiController@postComment')->name('apiPostComment');
    Route::get('api/news/{news_id}/comments', 'ApiController@getNewsComments')->name('apiGetNewsComments');
    Route::delete('api/comment/{comment_id}', 'ApiController@deleteComment')->name('apiDeleteComment');
});


	
