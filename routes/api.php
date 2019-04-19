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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register','AuthController@register');
});

Route::resource('galleries','GalleriesController')->except([
    'create','edit'
]);   

Route::get('galleries/page','GalleriesController@index');
Route::get('/authors-galleries/{id}','AuthorGalleriesController@index');
Route::get('my-galleries','MyGalleriesController@show');
Route::post('my-galleries/{id}','CommentsController@store');
Route::delete('/comment/{id}','CommentsController@destroy');



