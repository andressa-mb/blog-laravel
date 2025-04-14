<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostAlert extends Model
{
    protected $table = 'post_alerts';
    protected $fillable = [
        'post_id', 'author_id'
    ];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }
}
