<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promosi extends Model
{
    use HasFactory;

    protected $table = 'promosi';
    protected $primaryKey = 'promosi_id';

    protected $fillable = [
        'judul',
        'tanggal_mulai',
    ];

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'promosi_id', 'promosi_id');
    }
}