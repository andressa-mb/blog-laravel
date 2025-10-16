<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserJson extends JsonResource
{
    /**
     * @var bool
     */

    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        //return parent::toArray($request); Assim envia todos os dados para todos
        return [
            "user" => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'lang' => $this->lang,
            ],
            "relations" => [
                'roles' => $this->roles->pluck('name'),
                'posts' => $this->posts->pluck('title', 'id'),
                'comments' => $this->comments->pluck('comments', 'id'),
                'followers' =>$this->followers->pluck('follower_id'),
                'followings' =>$this->followings->pluck('author_id'),
            ]

            //RoleJson::collection($this->whenLoaded('roles')),
            //ainda pode conter suas relações também chamando pelo resource
            //ex:  'posts' => PostResource::collection($this->posts),
            //método para adicionar as postagens do blog do usuário
        ];
    }
}
