<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservasi extends Model
{
    protected $table = 'reservasis';
    use Notifiable;

    protected $fillable = [
        'nama',
        'nomor_wa',
        'tanggal_reservasi',
        'waktu_reservasi',
        'jumlah_orang',
        'status',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'waktu_reservasi' => 'string',
        'jumlah_orang' => 'integer',
    ];

    /**
     * Get label for status.
     */
    public function getStatusLabelAttribute(): string
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
        ][$this->status] ?? $this->status;
    }

    /**
     * Get formatted nomor_wa (prepend 62 if starts with 0).
     */
    public function getFormattedWaAttribute(): string
    {
        $wa = $this->nomor_wa;

        // Hapus semua karakter selain angka
        $wa = preg_replace('/[^0-9]/', '', $wa);

        // Jika diawali 0 → ubah ke 62
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }

        // Jika sudah diawali 62 → biarkan
        if (str_starts_with($wa, '62')) {
            return $wa;
        }

        // fallback (kalau format aneh)
        return $wa;
    }
}
