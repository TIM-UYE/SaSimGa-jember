<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'kategori_id',
        'nama_menu',
        'harga',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id', 'kategori_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'menu_id', 'menu_id');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class, 'menu_id', 'menu_id');
    }

    public function prediksiPenjualan()
    {
        return $this->hasMany(PrediksiPenjualan::class, 'menu_id', 'menu_id');
    }
}