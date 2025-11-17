<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Resources\Categories\CategoryCollection;
use App\Http\Resources\Posts\PostCollection;
use App\Http\Resources\Posts\PostJson;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Lista de posts de todos os usuários registrados no sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function allPosts()
    {
        if($this->loggedUserIsAdmin()){
            $posts = Post::query()->with(['author:id,name', 'images']);

            return PostCollection::make($posts->paginate());
        }else {
            return response()->json([
                'message' => 'Usuário não autorizado.',
            ], 403);
        }
    }

    /**
     * Lista de posts do usuário autenticado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $userId = $this->userId();
            $posts = Post::query();
            $posts->whereHas('author', function($query) use($userId){
                $query->where('id', $userId);
            })
            ->with([
                'author:id,name',
                'images'
            ]);

            return PostCollection::make($posts->orderBy('id', 'desc')->get());
        }catch(Exception $error){
            return response()->json([
                'message' => `Usuário não autorizado. $error`,
            ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try{
            $validated = $request->validated();
            $postToCreate = $request->user()->posts()->create([
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);

            if($request->has('categories')){
                foreach($request->input('categories') as $cat){
                    $postToCreate->categories()->attach($cat);
                }
            }
            return response()->json([
                'post' => PostJson::make($postToCreate),
                'categories' => $request->input('categories')
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => "Erro ao criar post. {$e->getMessage()}",
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'message'=> 'Erro'
            ], 404);
        }
        return response()->json([
            'post' => PostJson::make($post)
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
