<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
class Role extends Model
{
    const admin = 'admin';
    const author = 'author';
    const reader = 'reader';

    protected $table = 'roles';
    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'deleted_at' => 'datetime:d-m-Y',
    ];

    /** Users que possuem esta role */
    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class, 'user_roles');
    }

    /** Query Scope para buscar apenas os usuários com role admin */
    public function scopeAdmin(Builder $builder): Builder{
        return $builder->where('name', static::admin);
    }

    /** Query Scope para buscar apenas os usuários com role autor */
    public function scopeAuthor(Builder $builder): Builder{
        return $builder->where('name', static::author);
    }

    /** Query Scope para buscar apenas os usuários com role reader */
    public function scopeReader(Builder $builder): Builder{
        return $builder->where('name', static::reader);
    }
}
