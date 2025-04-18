<?php

namespace App\Models;

use App\Utils\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PostImage extends Model
{
    const main = 1;
    const thumb = 2;
    const common = 3;
    const sizes = [
        self::main => ['width' => 250, 'height' => 520],
        self::thumb => ['width' => 70, 'height' => 100],
        self::common => ['width' => 400, 'height' => 480],
    ];
    protected $table = 'post_images';
    protected $fillable = [
        'post_id', 'path', 'type', 'width', 'height', 'description',
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

    public function scopeByType(Builder $q, int $type) : Builder {
        return $q->where([$this->qualifyColumn('type') => $type]);
    }

    public function scopeMain(Builder $q) : Builder {
        return $this->scopeByType($q, static::main);
    }

    public function scopeThumb(Builder $q) : Builder {
        return $this->scopeByType($q, static::thumb);
    }

    public function scopeCommon(Builder $q) : Builder {
        return $this->scopeByType($q, static::common);
    }

    public static function resolveImage(string $path, UploadedFile $file): string {
        try {
            /** @var Storage */
            $disk = Storage::disk('public');
            return $disk->putFileAs($path, $file, $file->getClientOriginalName());
        } catch(Throwable $e) {
            throw $e;
        }
    }

    public static function resolveMainImage(Post $post, UploadedFile $file): string {
        try {
            $date = $post->created_at->format('d-m-Y');
            return static::resolveImage("posts/$post->id/main-images/$date", $file);
        } catch(Throwable $e) {
            throw $e;
        }
    }

    public static function resolveThumbImage(Post $post, UploadedFile $file): string {
        try {
            $date = $post->created_at->format('d-m-Y');
            return static::resolveImage("posts/$post->id/thumb-images/$date", $file);
        } catch(Throwable $e) {
            throw $e;
        }
    }

    public static function resolveCommonImage(Post $post, UploadedFile $file): string {
        try {
            $date = $post->created_at->format('d-m-Y');
            return static::resolveImage("posts/$post->id/common-images/$date", $file);
        } catch(Throwable $e) {
            throw $e;
        }
    }


}
