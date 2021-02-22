<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
    //Users
    Route::get('users/new-chat-room-search', 'UserController@search');
    Route::get('users/{id}/chat-rooms', 'UserController@getAllChatRooms');

    //ChatRooms
    Route::post('chat-rooms', 'ChatRoomController@store');
    Route::post('chat-rooms/{id}/messages', 'ChatRoomController@storeMessage');
    Route::get('chat-rooms/{id}/messages', 'ChatRoomController@getMessages');
});
