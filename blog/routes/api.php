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

Route::post('register', 'Api\UserController@store');
Route::get('login', 'Api\Auth\ConnectionController@login');

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', 'Api\Auth\ConnectionController@logout');
    Route::post('admin/logout-all', 'Api\Auth\ConnectionController@logoutAllUsers');
    Route::post('admin/create', 'Api\UserController@adminStore');

    Route::namespace('Api')->group(function () {
        Route::apiResources([
            'users' => 'UserController',
            'posts' => 'PostsController',
        ]);
    });
});

//para autorizar canais de broadcast
//Broadcast::routes(['middleware' => ['auth:sanctum']]);
