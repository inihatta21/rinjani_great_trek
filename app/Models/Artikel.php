<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $primaryKey = 'id_artikel';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul_artikel',
        'judul_artikel_en',
        'deskripsi',
        'deskripsi_en',
        'gambar_path',
    ];

    public function getJudulLocalizedAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->judul_artikel_en)) {
            return $this->judul_artikel_en;
        }

        return $this->judul_artikel;
    }

    public function getDeskripsiLocalizedAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->deskripsi_en)) {
            return $this->deskripsi_en;
        }

        return $this->deskripsi;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->gambar_path);
    }

    private function resolveImageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');

        if (is_file(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        if (is_file(public_path('storage/'.$cleanPath))) {
            return asset('storage/'.$cleanPath);
        }

        $legacyStorageFile = storage_path('app/public/'.$cleanPath);
        $publicTargetFile = public_path($cleanPath);

        if (is_file($legacyStorageFile)) {
            File::ensureDirectoryExists(dirname($publicTargetFile));
            @copy($legacyStorageFile, $publicTargetFile);

            if (is_file($publicTargetFile)) {
                return asset($cleanPath);
            }
        }

        return asset($cleanPath);
    }
}
