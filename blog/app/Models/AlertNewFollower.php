<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $author_id
 * @property int $follower_id
 * @property bool $readed
 * @property \Carbon\Carbon|null $processed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\User $author
 * @property \App\User $follower
 */
class AlertNewFollower extends Model
{
    use Traits\Readed;
    protected $table = 'alert_new_followers';
    protected $fillable = [
        'author_id', 'follower_id', 'readed', 'processed_at'
    ];

    protected $casts = [
        'readed' => 'boolean',
        'processed_at' => 'datetime:d-m-Y',
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    /** Autor que recebeu o novo seguidor */
    public function author(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'author_id', 'id');
    }

    /** Usuário que começou a seguir o autor */
    public function follower(): BelongsTo{
        return $this->belongsTo(\App\User::class, 'follower_id', 'id');
    }
}
