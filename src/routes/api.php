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

// 仮登録
Route::post('/preregister', 'Auth\RegisterController@preregister')->name('preregister');

// メールアドレス認証
Route::post('/register/verify', 'Auth\RegisterController@verify')->name('verify');

// 本登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// 全作品取得
Route::get('/products', 'ProductController@index')->name('products');

// 一作品取得
Route::get('/products/{id}', 'ProductController@show')->name('product.show');

// ユーザー情報取得
Route::get('/users/{userId}', 'UserController@show')->name('user.show');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
