<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    protected $table = 'comment';
    use Traits\SoftDeletes;

    protected $fillable = [
        'comments', 'user_id', 'post_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function alert(): HasOne{
        return $this->hasOne(AlertComment::class, 'comment_id', 'id');
    }
}
