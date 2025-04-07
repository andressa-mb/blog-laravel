<?php

namespace App;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lang', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany{
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function isAdmin(): bool{
        return $this->roles()->admin()->exists();
    }

    public function getIsAdminAttribute(): bool{
        return $this->isAdmin();
    }


}
