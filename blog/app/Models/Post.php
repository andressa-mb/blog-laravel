<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property \App\User $user
 * @property \App\User $author
 * @property \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property \App\Models\AlertPost|null $alertPost
 * @property \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property \Illuminate\Database\Eloquent\Collection|\App\PostImage[] $imagesPost
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $perPage = 20;
    use Traits\SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'content', 'slug'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'deleted_at' => 'datetime:d-m-Y',
    ];

    public static function booted(){
        parent::booted();
        static::creating(function (self $model){
            $model->slug = Str::slug($model->title);
        });

        static::updating(function (self $model){
            $model->slug = Str::slug($model->title);
        });

        static::deleting(function (self $model){
            $model->slug.= '-delete-' .time();

            foreach($model->imagesPost as $image){
                Storage::disk('public')->delete($image->url);
            }
        });
    }

    /** Usuário que criou o post */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** Alias para user() */
    public function author(): BelongsTo{
        return $this->user();
    }

    /** Comentários do post */
    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    /** Alerta gerado referente ao post */
    public function alertPost(): HasOne{
        return $this->hasOne(AlertPost::class, 'post_id', 'id');
    }

    /** Categorias associadas ao post */
    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    /** Imagens do post */
    public function imagesPost(): HasMany {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    /** Nome da rota gerada para a URI  */
    public function getRouteKeyName(){
        return 'slug';
    }

    /** Método para pegar os ids das categorias relacionados ao post */
    public function categoriesIds(): array{
        $categoriesIds = [];
        foreach($this->categories()->get(['categories.id']) as $categories){
            $categoriesIds[] = $categories->pivot->category_id;
        }
        return $categoriesIds;
    }
}
