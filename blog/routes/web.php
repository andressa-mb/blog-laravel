<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/set-lang', 'Lang\LangController@setLang')->name('locale.setLang');

Route::get('/', function (Request $request) {
    $user = $request->user();
    return view('welcome', ['user' => $user]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/{post}', 'HomeController@show')->name('post');
Route::resource('/posts', 'Posts\PostController');
