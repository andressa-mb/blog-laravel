<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comment';
    use Traits\SoftDeletes;

    protected $fillable = [
        'comments', 'user_id', 'post_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
