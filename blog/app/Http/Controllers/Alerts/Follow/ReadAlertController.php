<?php

namespace App\Http\Controllers\Alerts\Follow;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController as Controller;
use App\Models\AlertNewFollower;

class ReadAlertController extends Controller
{
    //** Função para marcar como lido o alerta de novo seguidor */
    public function __invoke(AlertNewFollower $alert)
    {
        $alert->readed = true;
        $alert->save();
        return redirect()->route('web.users.index');
    }
}
