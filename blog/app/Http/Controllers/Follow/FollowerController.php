<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
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
        $user->followings()->firstOrCreate([
            'author_id' => $author->id,
        ]);
        return back();
    }

    public function unfollow(User $author){
        /**  @var \App\User */
        $user = auth()->user();
        $user->followings()->where(['author_id' => $author->id])->delete();

        return back();
    }
}
