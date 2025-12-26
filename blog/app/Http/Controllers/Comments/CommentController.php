<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\WebController as Controller;
use App\Http\Requests\Comments\StoreComment;
use App\Jobs\Comments\AlertJob;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = DB::table('comments')->join('posts', 'comments.post_id', '=', 'posts.id')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->leftJoin('post_images', function($join){
            $join->on('post_images.post_id', '=', 'posts.id')
            ->where('post_images.type', '=', 1);
        })
        ->select([
            'comments.id',
            'comments.post_id',
            'comments.comment',
            'comments.created_at',
            'users.name as userName',
            'posts.slug as slug',
            'posts.title as postTitle',
            'posts.content as content',
            'post_images.path as imagePath',
            'post_images.description as imageDescription',
        ])->orderBy('comments.post_id', 'asc')
        ->get()->groupBy('post_id');

        $commentsForPost = $comments->map(function($value){
            return [
                'post' => [
                    'slug' => $value->first()->slug,
                    'title' => $value->first()->postTitle,
                    'content' => $value->first()->content,
                    'imagePath' => $value->first()->imagePath,
                    'imageDescription' => $value->first()->imageDescription,
                ],
                'comments' => $value
            ];
        });

        return view('comments.index', ['commentsForPost' => $commentsForPost]);
    }

    /**
     * Armazenar um novo comentário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request)
    {
        try{
            $input = $request->validated();
            $user = $request->user();
            $comment = $user->comments()->create([
                'comment' => $input['comment'],
                'post_id' => $request->post_id,
            ]);
            AlertJob::dispatch($comment);
            return back();
        }catch(Throwable $e){
            report($e);
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Atualização de um comentário em específico.
     *
     * @param  \App\Models\Comment $comment
     * @param App\Http\Requests\Comments\StoreComment $request
     * @return \Illuminate\Routing\Redirector
     */
    public function update(StoreComment $request, Comment $comment)
    {
        if($this->userId() == $comment->user_id){
            $updatedComment = $request->validated();
            $comment->update($updatedComment);

            return back()->with('success', 'Comentário atualizado.');
        }

        return back()->with('warning', 'Não autorizado ou erro de validação.');

    }

    /**
     * Remove o comentário em específico.
     *
     * @param  \App\Models\Comment $comment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Comment $comment)
    {
        if($this->userId() == $comment->user_id || $this->loggedUserIsAdmin()){
            $comment->delete();
            return back()->with('success', 'Comentário excluído.');
        }

        return back()->with('danger', 'Não autorizado.');
    }
}
