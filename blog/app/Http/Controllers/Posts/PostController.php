<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\WebController as Controller;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Jobs\Posts\AlertJob;
use App\Models\AlertComment;
use App\Models\Category;
use App\Models\Post;
use App\Services\Categories\CategoryService;
use Exception;
use Throwable;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Lista de Posts do usuário autenticado.
     * @return View
    */
    public function index()
    {
        $user = $this->userLogged();
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Form para criação de um novo post, informando a lista de categorias para associar
     * @return View
    */
    public function create()
    {
        return view('posts.create', ['categories' => Category::get()]);
    }

    /**
     * Armazenar um novo post e associa a categorias se for selecionado.
     *
     * @param App\Http\Requests\Posts\StoreRequest $request
     * @return \Illuminate\Routing\Redirector
    */
    public function store(StoreRequest $request)
    {
        try{
            $user = $this->userLogged();
            $validate = $request->validated();
            $post = $user->posts()->create([
                'title' => $validate['title'],
                'content' => $validate['content'],
            ]);

            //Associando novas categorias ao post
            if($request->has('categories')){
                CategoryService::new()->addToCategory($request->categories, $post);
            }

            $alert = $post->alertPost()->create([
                'author_id' => $post->user_id,
            ]);
            AlertJob::dispatch($alert);

            return redirect()->route('insert-images', $post);
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Página do post selecionado.
     *
     * @param \App\Models\Post $post
     * @return View
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Form de edição do post específico e suas categorias associadas.
     *
     * @param \App\Models\Post $post
     * @return View
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $this->data['post'] = $post;
        $this->data['categories'] = Category::get();
        $this->data['categories_ids'] = $post->categoriesIds();
        return view('posts.edit', $this->data);
    }

    /**
     * Atualizar um post específico e as categorias se houver alterações.
     *
     * @param  App\Http\Requests\Posts\UpdateRequest $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Post $post)
    {
        try{
            $validate = $request->validated();
            $post->update([
                'title' => $validate['title'],
                'content' => $validate['content'],
            ]);

            //Removendo e acionando novas categorias
            if($request->has('categories')){
                CategoryService::new()->associateCategories($request->categories, $post);
            }

            if(!$post->images()->exists()){
                return redirect()->route('insert-images', ['post' => $post]);
            }

            return redirect()->route('edit-images', ['post' => $post]);
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove um post em específico
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Post $post)
    {
        try{
            $this->authorize('delete', $post);
            $post->delete();
            return redirect()->route('web.posts.index')->with('success', 'Post deletado com sucesso.');
        }catch(Exception $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }
}
