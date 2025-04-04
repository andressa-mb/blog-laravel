<?php

namespace App\Http\Controllers\PostCategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsCategoriesController extends Controller
{
    public function addToCategory(Category $category, Post $post){
        $category->posts()->attach($post->id);
        return back();
    }

    public function removeFromCategory(Category $category, Post $post){
        $category->posts()->detach($post->id);
        return back();
    }
}
