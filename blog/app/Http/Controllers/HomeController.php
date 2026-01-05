<?php

namespace App\Http\Controllers;

use App\Models\AlertComment;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Página principal retornando lista de posts, posts recentes, último post gerado no sistema e lista de usuários registrados no sistema.
     * @return View
    */
    public function index() {
        $this->data['posts'] = Post::exists() ? Post::orderBy('created_at', 'desc')->paginate(6) : null;
        $this->data['recentPosts'] = Post::count() > 0 ? Post::orderBy('created_at', 'desc')->limit(3)->get() : null;
        $this->data['post'] = !is_null(Post::get()) ? Post::latest()->first() : null;
        $this->data['users'] = !is_null(User::get()) ? User::orderBy('created_at', 'desc')->limit(10)->get() : null;

        return view('home', $this->data);
    }

    /**
     * Página para mostrar o perfil do usuário logado. Apenas o próprio usuário pode ver esta página.
     * @param App\User $user
     * @return View
     */
    public function showProfile(User $user) {
        if($user == $this->userLogged()){
            return view('profile.index');
        }else {
            return back()->with('error', 'Usuário não autorizado.');
        }
    }
}
