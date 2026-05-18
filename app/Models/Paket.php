<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $primaryKey = 'id_paket';

    public $incrementing = true;

    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_paket',
        'nama_paket_en',
        'kategori',
        'kategori_id',
        'harga',
        'deskripsi',
        'deskripsi_en',
        'itinerary',
        'itinerary_en',
    ];

    public function getNamaPaketLocalizedAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->nama_paket_en)) {
            return $this->nama_paket_en;
        }

        return $this->nama_paket;
    }

    public function kategoriRelasi(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function getDeskripsiLocalizedAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->deskripsi_en)) {
            return $this->deskripsi_en;
        }

        return $this->deskripsi;
    }

    public function getItineraryLocalizedAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->itinerary_en)) {
            return $this->itinerary_en;
        }

        return $this->itinerary;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'kategori_id' => 'integer',
        ];
    }
}
