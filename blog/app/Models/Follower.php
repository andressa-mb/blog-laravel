<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $author_id
 * @property int $follower_id
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\User $author
 * @property \App\User $user
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AlertAuthorsFollowers[] $alertFollowers
 */
class Follower extends Model
{
    //quem me segue
    public $incrementing = false;
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $table = 'follows';
    protected $fillable = [
        'follower_id', 'followed_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    //Usuários que seguem Alguem → followers
    //Usuários que A segue → followings

    /** Autor que está sendo seguido */
    public function author(): BelongsTo{
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /** Usuário que segue o autor */
    public function follower(): BelongsTo{
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }

    /** Alertas gerados para o seguidor */
    public function alertFollowers(): HasMany{
        return $this->hasMany(AlertAuthorsFollowers::class, 'follower_id', 'follower_id');
    }
}
