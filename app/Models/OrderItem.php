<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'menu_id',
        'nama_menu',
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship to order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship to menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    /**
     * Calculate subtotal
     */
    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->harga * $this->qty;
    }

    /**
     * Format price for display
     */
    public function getFormattedHarga(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Format subtotal for display
     */
    public function getFormattedSubtotal(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
