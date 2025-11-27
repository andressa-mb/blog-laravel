<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function author(): BelongsTo{
        return $this->user();
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function alert(): HasOne{
        return $this->hasOne(PostAlert::class, 'post_id', 'id');
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, 'categories_posts');
    }

/*     public function imagesPost(): MorphMany {
        return $this->morphMany(Image::class, 'img');
    } */

    public function imagesPost(): HasMany {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function categoriesIds(): array{
        $categoriesIds = [];
        foreach($this->categories()->get(['categories.id']) as $categories){
            $categoriesIds[] = $categories->pivot->category_id;
        }
        return $categoriesIds;
    }
}
