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

Auth::routes();
Route::get('/', function (Request $request) {
    $user = $request->user();
    return view('welcome', ['user' => $user]);
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/{post}', 'HomeController@show')->name('post');
Route::post('/set-lang', 'Lang\LangController@setLang')->name('locale.setLang');

//POST
Route::resource('/posts', 'Posts\PostController');

//POST IMAGES
Route::post('posts/create/main-image/{post}', 'Posts\PostImageController@addMainImage')->name('posts.add-main-image');
Route::post('posts/create/thumb-image/{post}', 'Posts\PostImageController@addThumbImage')->name('posts.add-thumb-image');
Route::post('posts/create/images/{post}', 'Posts\PostImageController@addCommonImage')->name('posts.add-common-image');
Route::get('posts/add/image/{post}', 'Posts\PostImageController@addImage')->name('posts.add-image');

//CATEGORIA
Route::resource('/categories', 'Categories\CategoryController');
Route::get('/categorias/showAll/{post}', 'Categories\CategoryController@showAll')->name('categories.showAll');

//RELAÇÃO ADIÇÃO E REMOÇÃO - CATEGORIA E POST
Route::post('/add-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@addToCategory')->name('add-post-to-category');
Route::delete('/remove-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@removeFromCategory')->name('remove-post-from-category');

Route::post('/associate-category/post/{post}', 'PostCategory\PostsCategoriesController@associateCategories')->name('associate-post-to-category');
