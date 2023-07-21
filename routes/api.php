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
// echo 'asdads';
// die;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'Api\ApiController@login');
Route::post('register', 'Api\ApiController@register');
Route::post('forgot', 'Api\ApiController@forgot');
Route::post('update_password', 'Api\ApiController@update_password');
Route::post('pages', 'Api\ApiController@pages');
Route::post('categories', 'Api\ApiController@categories');
Route::post('category_by_id', 'Api\ApiController@category_by_id');
Route::post('contact', 'Api\ApiController@contact');
Route::post('books_by_cat_id', 'Api\ApiController@books_by_cat_id');
Route::post('top_trending', 'Api\ApiController@top_trending');
Route::post('book_detail', 'Api\ApiController@book_detail');
Route::post('books', 'Api\ApiController@books');
Route::post('author_listing', 'Api\ApiController@author_listing');
Route::post('rate_now', 'Api\ApiController@rate_now');
Route::post('social_login', 'Api\ApiController@social_login');
