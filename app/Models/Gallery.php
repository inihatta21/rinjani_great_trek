<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $primaryKey = 'id_foto';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_foto',
        'path',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->path);
    }

    private function resolveImageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        $fileName = basename(str_replace('\\', '/', trim($path)));
        if ($fileName === '' || $fileName === '.' || $fileName === '..') {
            return null;
        }

        return route('gallery.media', ['filename' => $fileName]);
    }
}
