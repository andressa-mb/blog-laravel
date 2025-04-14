<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
}
