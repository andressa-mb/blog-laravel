<?php

namespace App\Http\Resources\Posts;

use Illuminate\Http\Resources\Json\JsonResource;

class PostJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "post" => [
                'id' => $this->id,
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content,
                'user_id' => $this->author,
                'created_at' => $this->created_at->format('d-m-Y'),
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
            ],
            "relations" => [
                'images' => $this->images,
                'categories' => $this->categories->pluck('name'),
                'comments' => $this->comments
            ]
        ];
    }
}
