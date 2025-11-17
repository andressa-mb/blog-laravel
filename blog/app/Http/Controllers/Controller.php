<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * @var array
     */
    protected $data;

    public function user():? User{
        return Auth::user();
    }

    public function userId():? int{
        return Auth::id();
    }

    public function loggedUserIsAdmin():? bool{
        return $this->user()->isAdmin();
    }
}
