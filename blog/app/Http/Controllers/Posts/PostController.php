<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\WebController as Controller;
use App\Http\Requests\Posts\GetRequest;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Jobs\PostAlertJob;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user = $request->user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.createAll', ['categories' => Category::get()]);
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
            $user = $this->userLogged();
            $validate = $request->validated();
            if($validate){
                $post = $user->posts()->create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                ]);

                if($request->has('categories')){
                    foreach($request->categories as $category_id){
                        $post->categories()->attach($category_id);
                    }
                }
            }else {
                throw new Exception('Erro de validação.');
            }

            $alert = $post->alert()->create([
                'author_id' => $post->user_id,
            ]);
            PostAlertJob::dispatch($alert);

            return redirect()->route('insert-images', $post);
            //return redirect()->route('categories.showAll', ['post' => $post]);
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(GetRequest $request, Post $post)
    {
        $this->data['post'] = $post;
        return view('posts.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Post $post)
    {
        $input = $request->validated();
        $post->update([
            'title' => $input['title'],
            'content' => $input['content'],
        ]);
        return redirect()->route('categories.showAll', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('web.posts.index');
    }
}
