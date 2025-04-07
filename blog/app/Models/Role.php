<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    const admin = 'admin';
    const author = 'author';
    const reader = 'reader';

    protected $table = 'roles';
    protected $fillable = [
        'name'
    ];

    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function scopeAdmin(Builder $builder): Builder{
        return $builder->where('name', static::admin);
    }

    public function scopeAuthor(Builder $builder): Builder{
        return $builder->where('name', static::author);
    }

    public function scopeReader(Builder $builder): Builder{
        return $builder->where('name', static::reader);
    }
}
