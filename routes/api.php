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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/tampil/{id}', 'AuthController@index');
Route::get('/tampil', 'AuthController@show');
Route::put('/avatar/edit', 'AuthController@updateAvatar');
Route::put('/user/edit', 'AuthController@updateUser');
Route::put('/private/edit', 'AuthController@updatePrivate');

//chat
Route::get('/message/{id}', 'ChatController@index');
Route::get('/message/{sender_id}/{receiver_id}','ChatController@getMessage');
Route::post('/message/send', 'ChatController@sendMessage');