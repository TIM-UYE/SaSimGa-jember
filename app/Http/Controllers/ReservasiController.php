<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\KursiReservasi;
use App\Notifications\ReservasiStatusNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservasiController extends Controller
{
    /**
     * =========================
     * FRONTEND RESERVASI PAGE
     * =========================
     */
    public function frontend()
    {
        return view('frontend.reservasi.index');
    }

    /**
     * =========================
     * GET AVAILABLE TABLES (AJAX)
     * =========================
     */
    public function getAvailableTables(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $tanggal = $request->tanggal;
        $waktu = $request->waktu;

        $tables = Reservasi::getAvailableTables($tanggal, $waktu);

        return response()->json([
            'tables' => $tables,
        ]);
    }

    /**
     * =========================
     * ADMIN RESERVASI LIST
     * =========================
     */
    public function index()
    {
        $reservasis = Reservasi::orderBy('created_at', 'desc')->get();

        return view('admin.reservasi.index', compact('reservasis'));
    }

    /**
     * =========================
     * STORE RESERVASI
     * =========================
     */
    public function store(Request $request)
    {
        $mejaIds = $this->normalizeMejaIds($request->input('meja_ids', []));

        $request->merge([
            'meja_ids' => $mejaIds,
        ]);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'waktu_reservasi' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'meja_ids' => 'required|array|min:1',
            'meja_ids.*' => 'integer|exists:meja,id',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'tanggal_reservasi.required' => 'Tanggal reservasi wajib diisi.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh kurang dari hari ini.',
            'waktu_reservasi.required' => 'Waktu reservasi wajib diisi.',
            'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
            'jumlah_orang.min' => 'Jumlah orang minimal 1.',
            'meja_ids.required' => 'Silakan pilih minimal 1 meja.',
            'meja_ids.array' => 'Pilihan meja tidak valid.',
            'meja_ids.min' => 'Silakan pilih minimal 1 meja.',
        ]);

        // Validate 12-hour advance reservation
        $reservationDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal_reservasi . ' ' . $request->waktu_reservasi);
        $now = Carbon::now();
        $minReservationTime = $now->copy()->addHours(12);

        if ($reservationDateTime->lt($minReservationTime)) {
            return redirect()->back()
                ->withErrors([
                    'waktu_reservasi' => 'Reservasi harus dilakukan minimal 12 jam sebelum waktu reservasi. Waktu terdekat yang tersedia: ' . $minReservationTime->format('d M Y H:i'),
                ])
                ->withInput();
        }

        // Check table availability
        $bookedTables = KursiReservasi::whereIn('meja_id', $mejaIds)
            ->where('tanggal', $request->tanggal_reservasi)
            ->where('waktu_sesi', $request->waktu_reservasi)
            ->where('tersedia', false)
            ->count();

        if ($bookedTables > 0) {
            return redirect()->back()
                ->withErrors([
                    'meja_ids' => 'Beberapa meja sudah dipesan. Silakan pilih meja lain.',
                ])
                ->withInput();
        }

        $reservasi = Reservasi::create([
            'nama' => $request->nama,
            'nomor_wa' => $request->nomor_wa,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'waktu_reservasi' => $request->waktu_reservasi,
            'jumlah_orang' => $request->jumlah_orang,
            'status' => 'pending',
            'meja_ids' => $mejaIds,
        ]);

        // Mark tables as booked
        foreach ($mejaIds as $mejaId) {
            KursiReservasi::updateOrCreate(
                [
                    'meja_id' => $mejaId,
                    'tanggal' => $request->tanggal_reservasi,
                    'waktu_sesi' => $request->waktu_reservasi,
                ],
                [
                    'tersedia' => false,
                    'reservasi_id' => $reservasi->id,
                ]
            );
        }

        /**
         * SEND WHATSAPP NOTIFICATION
         */
        try {
            $reservasi->notify(new ReservasiStatusNotification($reservasi));
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification: ' . $e->getMessage());
        }

        return redirect()->back()->with(
            'success',
            'Reservasi berhasil dikirim! Silakan cek WhatsApp Anda untuk detail reservasi.'
        );
    }

    /**
     * =========================
     * UPDATE STATUS RESERVASI
     * =========================
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $reservasi = Reservasi::findOrFail($id);

        $reservasi->update([
            'status' => $request->status,
        ]);

        // If cancelled, free up the tables
        if ($request->status === 'cancelled') {
            if ($reservasi->meja_ids) {
                foreach ($reservasi->meja_ids as $mejaId) {
                    KursiReservasi::where('meja_id', $mejaId)
                        ->where('tanggal', $reservasi->tanggal_reservasi)
                        ->where('waktu_sesi', $reservasi->waktu_reservasi)
                        ->update([
                            'tersedia' => true,
                            'reservasi_id' => null,
                        ]);
                }
            }
        }

        return redirect()
            ->route('admin.reservasi.index')
            ->with(
                'success',
                'Status reservasi berhasil diperbarui. Notifikasi WhatsApp telah dikirim.'
            );
    }

    /**
     * =========================
     * DELETE RESERVASI
     * =========================
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Free up the tables first
        if ($reservasi->meja_ids) {
            foreach ($reservasi->meja_ids as $mejaId) {
                KursiReservasi::where('meja_id', $mejaId)
                    ->where('tanggal', $reservasi->tanggal_reservasi)
                    ->where('waktu_sesi', $reservasi->waktu_reservasi)
                    ->delete();
            }
        }

        $reservasi->delete();

        return redirect()
            ->route('admin.reservasi.index')
            ->with(
                'success',
                'Reservasi berhasil dihapus.'
            );
    }

    private function normalizeMejaIds(mixed $value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            } else {
                $value = explode(',', $value);
            }
        }

        if (! is_array($value)) {
            return [];
        }

        return collect($value)
            ->map(fn ($id) => filter_var($id, FILTER_VALIDATE_INT))
            ->filter(fn ($id) => $id !== false && $id > 0)
            ->unique()
            ->values()
            ->all();
    }
}
