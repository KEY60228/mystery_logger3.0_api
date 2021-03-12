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
Route::post('/preregister', 'PreRegisterController@preregister')->name('preregister');

// メールアドレス認証
Route::post('/register/verify', 'PreRegisterController@verify')->name('verify');

// 本登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// トップページ用
Route::get('/products', 'ProductController@index')->name('product.index');

// 一作品取得
Route::get('/products/{id}', 'ProductController@show')->name('product.show');

// クッキーログイン & ユーザー情報更新
Route::get('/currentuser', 'UserController@currentuser')->name('currentUser');

// ユーザー情報更新
Route::put('/users', 'UserController@update')->middleware('auth')->name('user.update');

// ユーザー情報取得
Route::get('/users/{userId}', 'UserController@show')->name('user.show');

// タイムライン取得
Route::get('/reviews', 'ReviewController@index')->middleware('auth')->name('review.timeline');

// レビュー登録
Route::post('/reviews', 'ReviewController@post')->middleware('auth')->name('review.post');

// 一レビュー取得
Route::get('/reviews/{reviewId}', 'ReviewController@show')->name('review.show');

// レビュー更新
Route::put('/reviews/{reviewId}', 'ReviewController@update')->middleware('auth')->name('review.update');

// レビュー削除
Route::delete('/reviews/{reviewId}', 'ReviewController@delete')->middleware('auth')->name('review.delete');

// ネタバレ取得
Route::get('/spoil/{reviewId}', 'ReviewController@spoil')->middleware('auth')->name('review.spoil');

// フォロー
Route::put('/follow', 'FollowController@follow')->middleware('auth')->name('follow');

// アンフォロー
Route::delete('/follow', 'FollowController@unfollow')->middleware('auth')->name('unfollow');

// 「行きたい」登録
Route::put('/wanna', 'WannaController@wanna')->middleware('auth')->name('wanna');

// 「行きたい」削除
Route::delete('/wanna', 'WannaController@unwanna')->middleware('auth')->name('unwanna');

// コメント投稿
Route::post('/comments/review', 'ReviewCommentController@post')->middleware('auth')->name('comment.review.post');

// レビューへのLike
Route::put('/likes/review', 'ReviewLikeController@like')->middleware('auth')->name('like.review');

// レビューへのLike取り消し
Route::delete('/likes/review', 'ReviewLikeController@unlike')->middleware('auth')->name('unlike.review');

// 主催者情報の取得
Route::get('/organizer/{organizerId}', 'OrganizerController@show')->name('organizer.show');

// 会場情報の取得
Route::get('/venues/{venueId}', 'VenueController@show')->name('venue.show');

// 同行者募集情報の取得
Route::get('/accompanies', 'AccompanyController@index')->name('accompanies');

// 団体一覧の取得 (検索用)
Route::get('/search/organizers', 'OrganizerController@search')->name('search.organizers');

// 会場一覧の取得 (検索用)
Route::get('/search/venues', 'VenueController@search')->name('search.venues');

// 検索結果の取得
Route::get('/search', 'ProductController@search')->name('search.result');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
