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

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('password/forgot-password', 'AuthController@forgotPassword');
Route::get('password/reset/{token}/{email}', 'AuthController@resetPasswordShow')->name('password.reset');
Route::post('password/reset', 'AuthController@resetPassword');

Route::middleware(['auth:api'])->group(function () {
    Route::get('logout', 'AuthController@logout');
    Route::resource('users', 'UserController')->middleware('role:admin');
    Route::resource('posts', 'PostController')->middleware('role:admin|editor');
    Route::post('posts/media/{post}', 'PostsMediaController@store')->middleware('role:admin|editor');
});
