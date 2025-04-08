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
    public function addImage(Post $post){
        $this->data['post'] = $post;
        return view('posts.add-image', $this->data);
    }

    public function addMainImage(Request $request, Post $post){
        $type = PostImage::main;
        $size = PostImage::resolveSizeByType($type);
        $filePath = $request->file('image');
        $post->images()->create([
            'path' => Storage::putFileAs('main-images', $filePath, $filePath->getClientOriginalName()),
            'type' => $type,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);

        return back();
    }

    public function addThumbImage(Request $request, Post $post){
        $type = PostImage::thumb;
        $size = PostImage::resolveSizeByType($type);
        $filePath = $request->file('image');
        $post->images()->create([
            'path' => Storage::putFileAs('thumb-images', $filePath, $filePath->getClientOriginalName()),
            'type' => $type,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);

        return back();
    }

    public function addCommonImage(Request $request, Post $post){
        $type = PostImage::common;
        $size = PostImage::resolveSizeByType($type);
        $filePath = $request->file('image');
        $post->images()->create([
            'path' => Storage::putFileAs('common-images', $filePath, $filePath->getClientOriginalName()),
            'type' => $type,
            'width' => $size['width'],
            'height' => $size['height'],
        ]);
    }
}
