<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $primaryKey = 'stok_id';

    protected $fillable = [
        'menu_id',
        'jumlah_stok',
        'stok_minimum',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    public function stokLog()
    {
        return $this->hasMany(StokLog::class, 'stok_id', 'stok_id');
    }
}