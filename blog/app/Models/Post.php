<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $table = 'posts';
    protected $perPage = 20;
    use Traits\SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'content', 'slug'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, 'categories_posts');
    }

    public function images(): HasMany{
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

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
        });
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
