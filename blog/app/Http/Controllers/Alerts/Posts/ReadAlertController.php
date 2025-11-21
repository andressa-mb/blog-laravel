<?php

namespace App\Http\Controllers\Alerts\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController as Controller;
use App\Models\FollowingAlert;

class ReadAlertController extends Controller
{
    //controller para marcar se está lido ou não
    public function __invoke(Request $request, FollowingAlert $alert)
    {
        $alert->readed = true;
        $alert->save();
        return redirect()->route('web.posts.show', $alert->post);
    }
}
