<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'galeri_id';

    protected $fillable = [
        'judul',
        'gambar',
        'profil_id',
        'promosi_id',
    ];

    public function profilUsaha()
    {
        return $this->belongsTo(ProfilUsaha::class, 'profil_id', 'profil_id');
    }

    public function promosi()
    {
        return $this->belongsTo(Promosi::class, 'promosi_id', 'promosi_id');
    }
}