<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    const main = 1;
    const thumb = 2;
    const common = 3;
    const sizes = [
        self::main => ['width' => 600, 'height' => 800],
        self::thumb => ['width' => 80, 'height' => 120],
        self::common => ['width' => 200, 'height' => 400],
    ];
    protected $table = 'post_images';
    protected $fillable = [
        'post_id', 'path', 'type', 'width', 'height'
    ];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public static function resolveSizeByType(int $type): array{
        if(array_key_exists($type, static::sizes)){
            return static::sizes[$type];
        }
       return static::sizes[static::common];
    }

}
