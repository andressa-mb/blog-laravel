<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Gate;

class PostImageController extends Controller
{
    /**
     * Direcionar para view de add imagens ao post
     *
     * @param App\Models\Post $post
     * @return View
     */
    public function addImages(Post $post){
        Gate::authorize('post-image', $post);
        $typeImages = $post->imagesPost()->whereIn('type', [1,3])->pluck('type')->all();
        $main = in_array(1, $typeImages);
        $thumb = in_array(3, $typeImages);
        return view('images.addImgToPost', ['post' => $post,  'hasThumb' => $thumb, 'hasMain' => $main]);
    }

    /**
     * Armazenar imagens à um post.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function storeImages(Post $post, Request $request){
        try{
            $validatedData = $request->validate([
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif',
                'typeImages' => 'required|in:1,2,3',
                'description' => 'nullable|string|max:255',
            ]);

            $file = $request->file('image_file');
            $size = PostImage::resolveSizeByType($validatedData['typeImages']);
            $typeName = PostImage::nameType($validatedData['typeImages']);
            $post->imagesPost()->create([
                'path' => PostImage::resolvePathImage($post, $typeName, $file),
                'type' => $validatedData['typeImages'],
                'description' => $validatedData['description'],
                'width' => $size['width'],
                'height' => $size['height'],
            ]);

            return back()->with('success', 'Imagem adicionada com sucesso!');
        }catch(Exception $e){
            throw $e;
            return back()->with('error', "Erro ao validar imagens.");
        }
    }

    /**
     * View para edição de imagens
     *
     * @param App\Models\Post $post
     * @return View
     */
    public function editImages(Post $post){
        Gate::authorize('post-image', $post);
        return view('images.edit-images', ['post' => $post]);
    }

    /**
     * Edição de imagens relacionadas à um post
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
    */
    public function changeImage(Post $post, PostImage $typeImg){
        try{
            if($typeImg->type == 1 || $typeImg->type == 3){
                PostImage::deleteImage($typeImg);
            }

            return redirect()->route('insert-images', $post);
        }catch(Exception $e) {
            throw $e;
            return back()->with('error', "Erro ao editar a imagem.");
        }
    }

    /**
     * Deletar imagem
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function deleteImage(PostImage $image){
        Gate::authorize('delete-image', $image);
        $deleted = PostImage::deleteImage($image);
        if(!$deleted) return back()->with('error', "Erro ao deletar a imagem.");

        return redirect()->back()->with('message', 'Imagem excluída com sucesso.');
    }
}
