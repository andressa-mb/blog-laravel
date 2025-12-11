<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $alertPost_id
 * @property int $post_id
 * @property int $author_id
 * @property int $follower_id
 * @property bool $readed
 * @property \Carbon\Carbon|null $processed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\AlertPost $alertPost
 * @property \App\Models\Post $post
 * @property \App\User $author
 * @property \App\User $follower
 */
class AlertAuthorsFollowers extends Model
{
    use Traits\Readed;
    protected $table = 'alert_authors_followers';
    protected $fillable = [
        'alertPost_id', 'post_id', 'author_id', 'follower_id', 'readed', 'processed_at'
    ];

    protected $casts = [
        'readed' => 'boolean',
        'processed_at' => 'datetime:d-m-Y',
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    /** Alerta principal a que este registro está vinculado */
    public function alertPost(): BelongsTo{
        return $this->belongsTo(AlertPost::class, 'alertPost_id', 'id');
    }

    /** Post relacionado ao alerta */
    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /** Autor que foi seguido */
    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    /** Seguidor que deve receber o alerta */
    public function follower(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'follower_id', 'id');
    }

}
