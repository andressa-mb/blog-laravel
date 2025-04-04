<?php

namespace App\Http\Controllers\Lang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function setLang(Request $request) {
        $lang = $request->lang;
        $user = $request->user();
        if(!is_null($user)){
            if($user->lang != $lang){
                $user->lang = $lang;
                $user->save();
            }
        }

        session(['locale' => $lang]);
        return back();
    }
}
