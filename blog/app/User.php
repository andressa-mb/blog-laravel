<?php

namespace App;

use App\Models\AlertComment;
use App\Models\AlertNewFollower;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\AlertAuthorsFollowers;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'created_at' => 'datetime:d-m-Y',
    ];

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Recebe ARRAY com nome de roles e busca na tabela ROLE pelo nome e retorna o ID para atualizar a planilha USER_ROLES
     * @param array $roleName
     * @return void
    */
    public function syncRoles(array $roleName): void {
        $roleIds = Role::whereIn('name', $roleName)->pluck('id')->toArray();
        $this->roles()->sync($roleIds);
    }

    /**
     * Recebe ARRAY com nome de roles, desassocia da tabela USER_ROLES caso já houvesse e associa todas as novas ROLES
     * @param array $roleName
     * @return void
     */
    public function getAndSetRole(array $roleName): void{
        foreach($roleName as $role){
            $setRole = Role::where('name', $role)->first();
            $this->roles()->detach($setRole->id);
            if($setRole){
                $this->roles()->attach($setRole->id);
            }
        }
    }

    /**
     * Verifiva se existe neste usuário a role ADMIN
     * @return bool
     */
    public function hasAdminRole(): bool{
        return $this->roles()->admin()->exists();
    }

    /**
     * Verifiva se o usuário tem a role ADMIN, buscando pelo atributo
     * @return bool
     */
    public function getIsAdminAttribute(): bool{
        return $this->hasAdminRole();
    }

    public function posts(): HasMany{
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /** Retorne a lista de todos os registros FOLLOW onde eu sou o seguido. (ou seja, outras pessoas que me seguem / quem me segue) */
    public function followers(): HasMany{
        return $this->hasMany(Follow::class, 'followed_id', 'id');
    }

    /** Retorne a lista de todos os registros FOLLOW onde eu sou o follower (ou seja, Eu(user) sigo outras pessoas logo é quem eu sigo). */
    public function followings(): HasMany{
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }

    /** Verifica se o usuário logado está seguindo o usuário passado como parâmetro. */
    public function isFollowing(User $user): bool{
        return $this->followings()->where(['followed_id' => $user->id])->exists();
    }

    //** Retorna a contagem de seguidores */
    public function countFollowings(): int{
        return $this->followings()->count();
    }

    //** Retorna a contagem de pessoas sendo seguidas */
    public function countFollowers(): int{
        return $this->followers()->count();
    }

    /** Retorna a lista de alertaa para os seguidores do autor do post */
    public function alertFollowers(): HasMany{
        return $this->hasMany(AlertAuthorsFollowers::class, 'follower_id', 'id');
    }

    /** Retorna a lista de alertas para o autor sobre novos seguidores */
    public function alertNewFollowers(): HasMany{
        return $this->hasMany(AlertNewFollower::class, 'author_id', 'id');
    }

    /** Retorna a lista de novos seguidores já LIDOS ou NÃO */
    public function queryAlertNewFollowers(bool $readed): HasMany {
        return $this->alertNewFollowers()->isReaded($readed);
    }

    /** Retorna a lista de alertas para o autor referente novo comentário no post */
    public function alertComments(): HasMany{
        return $this->hasMany(AlertComment::class, 'author_id', 'id');
    }

    /** Verifica se existe alerta de comentários */
    public function hasAnyAlertComments(): bool{
        return $this->alertComments()->exists();
    }

    /** Retorna a lista de comentários já LIDOS ou NÃO */
    public function queryAlertComments(bool $readed): HasMany{
        return $this->alertComments()->isReaded($readed);
    }

    /** Retorna se existe comentários LIDOS ou NÃO */
    public function hasAlertComments(bool $readed): bool{
        return $this->alertComments()->isReaded($readed)->exists();
    }

    /** Retorna a contagem total de alerta de comentários LIDOS OU NÃO */
    public function countAlertComments(bool $readed): int{
        return $this->alertComments()->isReaded($readed)->count();
    }

    /** Retorna a contagem total de alertas de comentários */
    public function countAnyAlertComments(): int{
        return $this->alertComments()->count();
    }

    /** Retorna a lista de alertas para os seguidores do autor referente um novo post criado por ele. */
    public function alertNewPostToFollowers(): HasMany{
        return $this->hasMany(AlertAuthorsFollowers::class, 'follower_id', 'id');
    }

    /** Verifica se existe qualquer alerta de um novo post */
    public function hasAnyAlertNewPost(): bool{
        return $this->alertNewPostToFollowers()->exists();
    }

    /** Retorna se existe alerta de novos posts LIDOS ou NÃO */
    public function hasAlertNewPost(bool $readed=false): bool{
        return $this->alertNewPostToFollowers()->isReaded($readed)->exists();
    }

    /** Retorna a lista de alertas de posts novos LIDOS ou NÃO */
    public function queryAlertReadedNewPost(bool $readed): HasMany{
        return $this->alertNewPostToFollowers()->isReaded($readed);
    }

    /** Retorna a contagem de alertas de novos posts LIDOS ou NÃO para os seguidores */
    public function countAlertNewPosts(bool $readed=false): bool{
        return $this->alertNewPostToFollowers()->isReaded($readed)->count();
    }

    /** Retorna a contagem de alertas de novos posts do autor em específico passado, alertas LIDOS ou NÃO */
    public function countAlertNewPostsFrom(User $author, bool $readed=false): bool{
        return $this->alertNewPostToFollowers()->isReaded($readed)->where('author_id', $author->id)->count();
    }
}
