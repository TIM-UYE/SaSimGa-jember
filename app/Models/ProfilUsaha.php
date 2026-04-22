<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilUsaha extends Model
{
    use HasFactory;

    protected $table = 'profil_usaha';
    protected $primaryKey = 'profil_id';

    protected $fillable = [
        'nama_usaha',
        'visi',
        'alamat',
    ];

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'profil_id', 'profil_id');
    }
}