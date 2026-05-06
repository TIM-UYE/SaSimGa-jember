<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Notifications\ReservasiStatusNotification;
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'waktu_reservasi' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'tanggal_reservasi.required' => 'Tanggal reservasi wajib diisi.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh kurang dari hari ini.',
            'waktu_reservasi.required' => 'Waktu reservasi wajib diisi.',
            'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
            'jumlah_orang.min' => 'Jumlah orang minimal 1.',
        ]);

        $reservasi = Reservasi::create([
            'nama' => $request->nama,
            'nomor_wa' => $request->nomor_wa,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'waktu_reservasi' => $request->waktu_reservasi,
            'jumlah_orang' => $request->jumlah_orang,
            'status' => 'pending',
        ]);

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

        $reservasi->delete();

        return redirect()
            ->route('admin.reservasi.index')
            ->with(
                'success',
                'Reservasi berhasil dihapus.'
            );
    }
}
