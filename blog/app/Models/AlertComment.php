<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertComment extends Model
{
    protected $table = 'alert_comments';
    protected $fillable = [
        'comment_id', 'post_id', 'author_id', 'readed',
    ];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    public function comment(): BelongsTo{
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function scopeIsReaded(Builder $builder, bool $isReaded = true): Builder{
        return $builder->where([$this->qualifyColumn('readed') => $isReaded]);
    }
}
