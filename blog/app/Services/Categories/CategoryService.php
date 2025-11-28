<?php

namespace App\Services\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryService {

    public static function new(): self {
        return app()->make(static::class);
    }

    public function addToCategory(array $categories, Post $post): void{
        foreach($categories as $category_id){
            $post->categories()->attach($category_id);
        }
    }

    public function removeFromCategory(Category $category, Post $post){
        $category->posts()->detach($post->id);
        return back();
    }

    public function associateCategories(array $categories, Post $post): void{
        $post->categories()->detach();

        foreach($categories as $category_id){
            $post->categories()->attach($category_id);
        }
    }

}
