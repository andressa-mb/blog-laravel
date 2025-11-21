<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImageController extends Controller
{
    public function addImages(Post $post){
        $typeImages = $post->imagesPost()->whereIn('type', [1,3])->pluck('type')->all();
        $main = in_array(1, $typeImages);
        $thumb = in_array(3, $typeImages);
        return view('posts.imgToPost', ['post' => $post,  'hasThumb' => $thumb, 'hasMain' => $main]);
    }

    public function storeImages(Post $post, Request $request){
        try{
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif', // 2MB max, deve ser imagem
                'typeImages' => 'required|in:1,2,3', // O tipo deve ser um desses valores
                'description' => 'nullable|string|max:255',
            ]);

            if(!$validatedData){
                dump('entrou no if do validate da imagem');
                throw new Exception;
            }
            $size = Image::resolveSizeByType($validatedData['typeImages']);
            $typeName = Image::nameType($validatedData['typeImages']);
            $post->imagesPost()->create([
                'url' => Image::resolvePathImage($post, $typeName, $validatedData['image']),
                'type' => $validatedData['typeImages'],
                'description' => $validatedData['description'],
                'width' => $size['width'],
                'height' => $size['height'],
            ]);

            return back()->with('success', 'Imagem adicionada com sucesso!');
        }catch(Exception $e){
            return back()->with('error', "Erro ao adicionar as imagens. $e");
        }
    }


    /* public function createMainImage(Post $post){
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
    } */
}
