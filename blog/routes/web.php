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

Route::get('/list-users', function (){
    return view('profile.list-users');
})->middleware('auth', 'checkRole')->name('list-users');

Route::get('/list-posts', function() {
    return view('posts.list-posts');
})->name('list-posts');

Auth::routes();
//HOME para usuários e VISITANTES (principalmente)
Route::get('/', 'HomeController@index')->name('home.index');
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home-show/{post}', 'HomeController@show')->name('home.show');
Route::post('/set-lang', 'Lang\LangController@setLang')->name('locale.setLang');
Route::get('/alert/following/post/{alert}', 'Alerts\Posts\ReadAlertController')->name('alert-following-post');

//PERFIL USUÁRIO
Route::get('/home/meu-perfil/{user}', 'HomeController@showPerfil')->name('show-perfil');

//COMENTÁRIOS
Route::resource('/comments', 'Comments\CommentController');

//FOLLOW
Route::post('/follow/{author}', 'Follow\FollowerController@follow')->name('follow-author');
Route::delete('/unfollow/{author}', 'Follow\FollowerController@unfollow')->name('unfollow-author');

//CATEGORIA
Route::name('web.')->group(function () {
    Route::resource('/categories', 'Categories\CategoryController');
});

//POST
Route::name('web.')->group(function () {
    Route::resource('/posts', 'Posts\PostController');
});

//NOVO REFERENTE A ASSOCIAÇÃO DE IMAGENS
Route::get('/insert-images/{post}', 'Posts\PostImageController@addImages')->name('insert-images'); //ok
Route::post('/store-images/{post}', 'Posts\PostImageController@storeImages')->name('store-images'); //ok
Route::get('/change-image/{post}/image/{typeImg}', 'Posts\PostImageController@changeImage')->name('change-image'); // ok
Route::get('/delete-image/{image}', 'Posts\PostImageController@deleteImage')->name('delete-image');
Route::get('/edit-images/{post}', 'Posts\PostImageController@editImages')->name('edit-images'); //view ok



//RELAÇÃO ADIÇÃO E REMOÇÃO - CATEGORIA E POST
Route::post('/add-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@addToCategory')->name('add-post-to-category');
Route::delete('/remove-category/category/{category}/post/{post}', 'PostCategory\PostsCategoriesController@removeFromCategory')->name('remove-post-from-category');
//ASSOCIAÇÃO DA CATEGORIA AO POST
Route::post('/associate-category/post/{post}', 'PostCategory\PostsCategoriesController@associateCategories')->name('associate-post-to-category');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Ver o thema do Bootstrap 5 no jobick
Route::get('/jobick', function () {
    return view('jobick.jobick-view');
});
