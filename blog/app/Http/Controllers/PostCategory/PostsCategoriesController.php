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

    public function associateCategories(Request $request, Post $post){
        $post->categories()->detach();
        if(is_array($request->categories)){
            foreach($request->categories as $category_id){
                $post->categories()->attach($category_id);
            }
        }

        return redirect()->route('posts.add-image', $post);
    }
}
