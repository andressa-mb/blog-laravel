<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = [
        'user_id', 'comment', 'post_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
