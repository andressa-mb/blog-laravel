<?php

namespace App;

use App\Models\AlertComment;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Following;
use App\Models\Post;
use App\Models\Role;
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

    public function alertComments(): HasMany{
        return $this->hasMany(AlertComment::class, 'author_id', 'id');
    }

    public function hasAlertComments(bool $readed): bool{
        return $this->alertComments()->isReaded($readed)->exists();
    }

    public function countAlertComments(bool $readed): int{
        return $this->alertComments()->isReaded($readed)->count();
    }

    public function hasAnyAlertComments(): bool{
        return $this->alertComments()->exists();
    }

    public function countAnyAlertComments(): int{
        return $this->alertComments()->count();
    }

    public function queryAlertComments(bool $readed): HasMany{
        return $this->alertComments()->isReaded($readed);
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

    public function followers(): HasMany{
        return $this->hasMany(Follower::class, 'author_id', 'id');
    }

    public function followings(): HasMany{
        return $this->hasMany(Following::class, 'follower_id', 'id');
    }

    public function isFollowing(User $user): bool{
        return $this->followings()->where(['author_id' => $user->id])->exists();
    }

}
