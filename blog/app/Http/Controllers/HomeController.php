<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //middleware de autenticação - logo só visualiza quem está autenticado
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $this->data['user']= $request->user();
        $this->data['posts'] = Post::exists() ? Post::orderBy('created_at', 'desc')->paginate(6) : null;
        $this->data['recentPosts'] = Post::count() > 0 ? Post::orderBy('created_at', 'desc')->limit(3)->get() : null;
        $this->data['post'] = !is_null(Post::get()) ? Post::latest()->first() : null;
        return view('home', $this->data);
    }

    public function show(Request $request, Post $post){
        $this->data['user']= $request->user();
        $this->data['post'] = $post;
        return view('show', $this->data);
    }

    public function showPerfil(Request $request){
        $this->data['user']= $request->user();
        return view('profile.index', $this->data);
    }
}
