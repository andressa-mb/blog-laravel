<?php

namespace App\Http\Controllers\Alerts\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController as Controller;
use App\Models\AlertComment;

class ReadAlertController extends Controller
{
    //** Função para marcar como lido o alerta de novo comentário */
    public function __invoke(AlertComment $alert)
    {
        $alert->readed = true;
        $alert->save();
        return redirect()->route('web.posts.show', $alert->post);
    }
}
