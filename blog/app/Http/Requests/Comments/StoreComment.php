<?php

namespace App\Http\Requests\Comments;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreComment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
   /*      $postsDoUser = Post::where('user_id', $request->user()->id )->get();
        if($postsDoUser->contains($request->post_id)){
            return false;
        }else {
            return true;
        } */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|min:3|max:300',
        ];
    }

    public function messages(){
        return [
            'comment.required' => 'Campo obrigatório.',
            'comment.min' => 'Minimo de 3 caracteres.',
            'comment.max' => 'Máximo de 300 caracteres.',
        ];
    }
}
