<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowingAlert extends Model
{
    use Traits\Readed;
    protected $table = 'following_alerts';
    protected $fillable = [
        'alert_id', 'post_id', 'author_id', 'follower_id', 'readed'
    ];

    public function alert(): BelongsTo{
        return $this->belongsTo(PostAlert::class, 'alert_id', 'id');
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    public function follower(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'follower_id', 'id');
    }

}
