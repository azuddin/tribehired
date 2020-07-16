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

Route::get('posts', 'PostController@index')->name('post_list');
Route::get('posts/{post}', 'PostController@show')->name('post_list');

Route::get('comments', 'CommentController@index')->name('comment_list');
Route::post('comments', 'CommentController@store')->name('comment_add');