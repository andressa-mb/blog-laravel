<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewFollowAlert extends Model
{
    use Traits\Readed;
    protected $table = 'new_follow_alerts';
    protected $fillable = [
        'author_id', 'follower_id', 'readed'
    ];

    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    public function follower(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'follower_id', 'id');
    }
}
