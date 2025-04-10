<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImageController extends Controller
{
    public function createMainImage(Post $post){
        return view('images.add-main-image', ['post' => $post]);
    }

    public function addMainImage(Request $request, Post $post){
        $type = PostImage::main;
        $size = PostImage::resolveSizeByType($type);
        $post->images()->create([
            'path' => PostImage::resolveMainImage($post, $request->file('image')),
            'type' => $type,
            'description' => $request->description,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);
        return redirect()->route('images.add-thumb-image', $post);
    }

    public function createThumbImage(Post $post){
        return view('images.add-thumb-image', ['post' => $post]);
    }

    public function addThumbImage(Request $request, Post $post){
        $type = PostImage::thumb;
        $size = PostImage::resolveSizeByType($type);
        $post->images()->create([
            'path' => PostImage::resolveThumbImage($post, $request->file('image')),
            'type' => $type,
            'description' => $request->description,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);

        return redirect()->route('images.add-common-image', $post);
    }

    public function createCommonImage(Post $post){
        return view('images.add-common-image', ['post' => $post]);
    }

    public function addCommonImage(Request $request, Post $post){
        $type = PostImage::common;
        $size = PostImage::resolveSizeByType($type);
        $post->images()->create([
            'path' => PostImage::resolveCommonImage($post, $request->file('image')),
            'type' => $type,
            'description' => $request->description,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);

        return back();
    }
}
