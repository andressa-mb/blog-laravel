<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * @property int $id
 * @property int $post_id
 * @property string $path
 * @property int $type
 * @property int $width
 * @property int $height
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $description
 *
 * @property \App\Models\Post $post
 */
class PostImage extends Model
{
    const main = 1;
    const common = 2;
    const thumb = 3;

    const sizes = [
        self::main => ['width' => 640, 'height' => 520],
        self::common => ['width' => 520, 'height' => 480],
        self::thumb => ['width' => 100, 'height' => 100],
    ];

    protected $table = 'post_images';
    protected $fillable = [
        'post_id', 'path', 'type', 'width', 'height', 'description',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    /** Post ao qual a imagem pertence */
    public function post(): BelongsTo{
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /** Método para buscar o tamanho do tipo de imagem selecionado */
    public static function resolveSizeByType(int $type): array{
        if(array_key_exists($type, static::sizes)){
            return static::sizes[$type];
        }
       return static::sizes[static::common];
    }

    /** Método para buscar o nome do tipo seleciona */
    public static function nameType(int $type): string{
        $typeName = '';
        if($type == static::main){
            $typeName = 'main';
        } else if($type == static::common){
            $typeName = 'common';
        }else {
            $typeName = 'thumb';
        }

        return $typeName;
    }

    /** Método para armazenar a imagem no Storage do projeto */
    public static function storageImage(string $path, UploadedFile $file): string {
        try {
            /** @var Storage */
            $disk = Storage::disk('public');
            return $disk->putFileAs($path, $file, $file->getClientOriginalName());
        } catch(Throwable $e) {
            throw $e;
        }
    }

    /** Método para setar o nome do arquivo da imagem */
    public static function resolvePathImage(Post $post, string $typeName, UploadedFile $file): string {
        try {
            $date = $post->created_at->format('d-m-Y');
            return static::storageImage("posts/$post->id/$typeName-images/$date", $file);
        } catch(Throwable $e) {
            throw $e;
        }
    }

    /** Método para deletar a imagem do banco e do Storage do projeto */
    public static function deleteImage(PostImage $image): bool{
        try{
            Storage::disk('public')->delete($image->url);
            $image->delete();
            return true;
        } catch(Throwable $e) {
            throw $e;
        }
    }
}
