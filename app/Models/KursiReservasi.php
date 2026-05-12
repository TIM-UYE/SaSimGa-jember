<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KursiReservasi extends Model
{
    protected $table = 'kursi_reservasi';

    protected $fillable = [
        'meja_id',
        'tanggal',
        'waktu_sesi',
        'tersedia',
        'reservasi_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_sesi' => 'string',
        'tersedia' => 'boolean',
    ];

    /**
     * Get the table that owns this seat reservation.
     */
    public function meja(): BelongsTo
    {
        return $this->belongsTo(Meja::class);
    }

    /**
     * Get the reservation that owns this seat.
     */
    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class);
    }

    /**
     * Check if this seat is available for booking.
     */
    public function isTersedia(): bool
    {
        return $this->tersedia && $this->meja && $this->meja->is_active;
    }
}
