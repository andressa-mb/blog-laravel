<?php

namespace App\Http\Controllers\Alerts\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController as Controller;
use App\Models\AlertAuthorsFollowers;

class ReadAlertController extends Controller
{
    //** Função para marcar como lido o alerta para os seguidores do autor de um novo post  */
    public function __invoke(Request $request, AlertAuthorsFollowers $alert)
    {
        $alert->readed = true;
        $alert->save();
        return redirect()->route('web.posts.show', $alert->post);
    }
}
