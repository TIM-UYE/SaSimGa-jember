<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokLog extends Model
{
    use HasFactory;

    protected $table = 'stok_log';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'stok_id',
        'tipe',
        'jumlah',
        'keterangan',
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id', 'stok_id');
    }
}