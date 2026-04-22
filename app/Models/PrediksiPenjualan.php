<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrediksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'prediksi_penjualan';
    protected $primaryKey = 'prediksi_id';

    protected $fillable = [
        'menu_id',
        'periode',
        'jumlah_prediksi',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}