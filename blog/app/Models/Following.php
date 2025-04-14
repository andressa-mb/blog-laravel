<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Following extends Model
{
     //meus seguidores - user que me segue
     public $incrementing = false;
     protected $table = 'followings';
     protected $fillable = [
         'author_id', 'follower_id'
     ];

    public function author(): BelongsTo{
         return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function follower(): BelongsTo{
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }
}
