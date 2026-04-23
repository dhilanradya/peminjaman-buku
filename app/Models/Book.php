<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'isbn',
        'kategori_id',
        'penerbit',
        'stok',
        'foto'
    ];

    // Accessor untuk status
    public function getStatusAttribute()
    {
        return $this->stok > 0 ? 'Tersedia' : 'Tidak Tersedia';
    }

    // Relationship
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
