<?php

namespace App;

use App\Models\AlertComment;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Following;
use App\Models\FollowingAlert;
use App\Models\Image;
use App\Models\NewFollowAlert;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lang',
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

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function syncRoles(array $roleName): void {
        $roleIds = Role::whereIn('name', $roleName)->pluck('id')->toArray();
        $this->roles()->sync($roleIds);
    }

    public function getAndSetRole(array $roleName): void{
        foreach($roleName as $role){
            $setRole = Role::where('name', $role)->first();
            $this->roles()->detach($setRole->id);
            if($setRole){
                $this->roles()->attach($setRole->id);
            }
        }
    }

    public function isAdmin(): bool{
        return $this->roles()->admin()->exists();
    }

    public function getIsAdminAttribute(): bool{
        return $this->isAdmin();
    }

    public function posts(): HasMany{
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function image(): MorphOne {
        return $this->morphOne(Image::class, 'img');
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

    public function postAlerts(): HasMany{
        return $this->hasMany(FollowingAlert::class, 'follower_id', 'id');
    }

    public function notReadedPostAlerts(): HasMany{
        return $this->postAlerts()->isReaded(false);
    }

    public function hasPostAlerts(bool $readed=false): bool{
        return $this->postAlerts()->isReaded($readed)->exists();
    }

    public function countPostAlerts(bool $readed=false): bool{
        return $this->postAlerts()->isReaded($readed)->count();
    }

    public function countPostAlertsFrom(User $author, bool $readed=false): bool{
        return $this->postAlerts()->isReaded($readed)->where('author_id', $author->id)->count();
    }

//quem me segue
    public function followers(): HasMany{
        return $this->hasMany(Follower::class, 'author_id', 'id');
    }
//estou seguindo
    public function followings(): HasMany{
        return $this->hasMany(Following::class, 'follower_id', 'id');
    }

    public function isFollowing(User $user): bool{
        return $this->followings()->where(['author_id' => $user->id])->exists();
    }

    public function countFollowings(): int{
        return $this->followings()->count();
    }

    public function countFollowers(): int{
        return $this->followers()->count();
    }

    public function followerAlerts(): HasMany{
        return $this->hasMany(FollowingAlert::class, 'follower_id', 'id');
    }

    public function newFollowerAlerts(): HasMany{
        return $this->hasMany(NewFollowAlert::class, 'author_id', 'id');
    }
}
