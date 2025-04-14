<?php
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
//HOME para usuários e VISITANTES (principalmente)
Route::get('/', 'HomeController@index')->name('home.index');
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home-show/{post}', 'HomeController@show')->name('home.show');
Route::post('/set-lang', 'Lang\LangController@setLang')->name('locale.setLang');

//PERFIL USUÁRIO
Route::get('/home/meu-perfil/{user}', 'HomeController@showPerfil')->name('show-perfil');

//COMENTÁRIOS
Route::resource('/comments', 'Comments\CommentController');

//FOLLOW
Route::post('/follow/{author}', 'Follow\FollowerController@follow')->name('follow-author');
Route::delete('/unfollow/{author}', 'Follow\FollowerController@unfollow')->name('unfollow-author');

//POST
Route::resource('/posts', 'Posts\PostController');

//POST IMAGES
Route::post('posts/create/main-image/{post}', 'Posts\PostImageController@addMainImage')->name('posts.add-main-image');
Route::post('posts/create/thumb-image/{post}', 'Posts\PostImageController@addThumbImage')->name('posts.add-thumb-image');
Route::post('posts/create/images/{post}', 'Posts\PostImageController@addCommonImage')->name('posts.add-common-image');

Route::get('posts/add/main-image/{post}', 'Posts\PostImageController@createMainImage')->name('images.add-main-image');
Route::get('posts/add/thumb-image/{post}', 'Posts\PostImageController@createThumbImage')->name('images.add-thumb-image');
Route::get('posts/add/common-image/{post}', 'Posts\PostImageController@createCommonImage')->name('images.add-common-image');

//CATEGORIA
Route::resource('/categories', 'Categories\CategoryController');
Route::get('/categorias/showAll/{post}', 'Categories\CategoryController@showAll')->name('categories.showAll');

//RELAÇÃO ADIÇÃO E REMOÇÃO - CATEGORIA E POST
Route::post('/add-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@addToCategory')->name('add-post-to-category');
Route::delete('/remove-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@removeFromCategory')->name('remove-post-from-category');
//ASSOCIAÇÃO DA CATEGORIA AO POST
Route::post('/associate-category/post/{post}', 'PostCategory\PostsCategoriesController@associateCategories')->name('associate-post-to-category');
