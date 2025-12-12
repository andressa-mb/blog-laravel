<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Jobs\Followers\AlertJob;
use App\User;

class FollowerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function follow(User $authorToFollow){
        /**  @var \App\User $user */
        $user = $this->userLogged();
        $follow = $user->followings()->create([
            'followed_id' => $authorToFollow->id,
        ]);

        AlertJob::dispatch($authorToFollow, $follow->follower_id);
        return back();
    }

    public function unfollow(User $authorToUnfollow){
        /**  @var \App\User $user */
        $user = $this->userLogged();
        $user->followings()->where(['followed_id' => $authorToUnfollow->id])->delete();

        return back();
    }
}
