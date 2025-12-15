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

// VUE ROTAS
Route::get('/list-users', function (){
    return view('profile.list-users');
})->middleware('auth', 'checkRole')->name('list-users');

Route::get('/list-posts', function() {
    return view('posts.list-posts');
})->name('list-posts');

/** Alteração de local para alterar idioma */
Route::post('/set-lang', 'Lang\LangController@setLang')->name('locale.setLang');

/** Página principal - HOME para usuários e VISITANTES */
Route::get('/', 'HomeController@index')->name('home.index');

/** Página do perfil do usuário logado */
Route::get('/home/my-profile/{user}', 'HomeController@showProfile')->name('home.show-my-profile');

//COMENTÁRIOS
Route::resource('/comments', 'Comments\CommentController');

//FOLLOW
Route::post('/follow/{authorToFollow}', 'Follow\FollowerController@follow')->name('follow-author');
Route::delete('/unfollow/{authorToUnfollow}', 'Follow\FollowerController@unfollow')->name('unfollow-author');

//CATEGORIA E POSTS
Route::name('web.')->group(function () {
    Route::get('/check-readed-alert-comment/{alert}/', 'Alerts\Comments\ReadAlertController')->name('check-readed-comment-alert');
    Route::get('/check-readed-alert-new-post/{alert}', 'Alerts\Posts\ReadAlertController')->name('check-readed-new-post-alert');
    Route::get('/check-readed-alert-new-follower/{alert}', 'Alerts\Follow\ReadAlertController')->name('check-readed-new-follower-alert');

    Route::resources([
        'categories' => 'Categories\CategoryController',
        'posts' => 'Posts\PostController',
        'users' => 'Users\UserController',
    ]);
});

// IMAGENS
Route::get('/insert-images/{post}', 'Posts\PostImageController@addImages')->name('insert-images');
Route::post('/store-images/{post}', 'Posts\PostImageController@storeImages')->name('store-images');
Route::get('/change-image/{post}/image/{typeImg}', 'Posts\PostImageController@changeImage')->name('change-image');
Route::get('/delete-image/{image}', 'Posts\PostImageController@deleteImage')->name('delete-image');
Route::get('/edit-images/{post}', 'Posts\PostImageController@editImages')->name('edit-images');

//Ver o thema do Bootstrap 5 no jobick
Route::get('/jobick', function () {
    return view('jobick.jobick-view');
});

