<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $comment
 * @property int $user_id
 * @property int $post_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property \App\User $user
 * @property \App\Models\Post $post
 * @property \App\Models\AlertComment|null $alertComment
 */
class Comment extends Model
{
    protected $table = 'comments';
    use Traits\SoftDeletes;

    protected $fillable = [
        'comment', 'user_id', 'post_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'deleted_at' => 'datetime:d-m-Y',
    ];

    /** Usuário que criou o comentário */
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** Post em que criou o comentário */
    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /** Alerta gerado referente ao comentário */
    public function alertComment(): HasOne{
        return $this->hasOne(AlertComment::class, 'comment_id', 'id');
    }
}
