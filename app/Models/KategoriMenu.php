<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $table = 'kategori_menu';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'kategori',
    ];

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kategori_id', 'kategori_id');
    }
}