<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSpecialItem extends Model
{
    use HasFactory;

    protected $table = 'menu_special_items';
    public $timestamps = true;

    protected $fillable = [
        'menu_special_id',
        'name',
        'price',
        'description',
        'image',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function menuSpecial()
    {
        return $this->belongsTo(MenuSpecial::class, 'menu_special_id', 'id');
    }
}
