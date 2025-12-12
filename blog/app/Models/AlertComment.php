<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $comment_id
 * @property int $post_id
 * @property int $author_id
 * @property bool $readed
 * @property \Carbon\Carbon|null $processed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Post $post
 * @property \App\User $author
 * @property \App\Models\Comment $comment
 * @method static \Illuminate\Database\Eloquent\Builder isReaded(bool $isReaded = true)
 */
class AlertComment extends Model
{
    use Traits\Readed;
    protected $table = 'alert_comments';
    protected $fillable = [
        'comment_id', 'post_id', 'author_id', 'readed', 'processed_at'
    ];

    protected $casts = [
        'readed' => 'boolean',
        'processed_at' => 'datetime:d-m-Y',
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    /** Post onde o comentário foi feito */
    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /** Autor que gerou o alerta (quem comentou) */
    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    /** Comentário que disparou o alerta */
    public function comment(): BelongsTo{
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
