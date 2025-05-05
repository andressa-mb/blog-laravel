<?php

namespace App\Http\Controllers\Alerts\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController as Controller;
use App\Models\AlertComment;

class ReadAlertController extends Controller
{
    //controller para marcar se está lido ou não
    public function __invoke(AlertComment $alert)
    {
        $alert->readed = true;
        $alert->save();
        return redirect()->route('posts.show', $alert->post);
    }
}
