<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Jobs\FollowJob;
use App\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function follow(User $author){
        /**  @var \App\User */
        $user = auth()->user();
        $follow = $user->followings()->firstOrCreate([
            'author_id' => $author->id,
        ]);
        //quero disparar para o autor que alguem seguiu ele
        FollowJob::dispatch($author, $follow->follower_id);
        return back();
    }

    public function unfollow(User $author){
        /**  @var \App\User */
        $user = auth()->user();
        $user->followings()->where(['author_id' => $author->id])->delete();

        return back();
    }
}
