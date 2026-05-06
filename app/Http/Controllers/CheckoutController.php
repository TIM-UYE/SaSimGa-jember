<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('frontend.menu')
                ->with('error', 'Keranjang Anda kosong. Silakan pilih menu terlebih dahulu.');
        }

        $total = $this->calculateTotal($cart);

        return view('frontend.checkout.index', compact('cart', 'total'));
    }

    /**
     * Process checkout
     */
    public function store(Request $request, WhatsAppService $whatsappService)
    {
        // Validate input
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500|required_if:metode_pengiriman,delivery',
            'catatan' => 'nullable|string|max:1000',
            'metode_pengiriman' => 'required|in:pickup,delivery',
            'metode_pembayaran' => 'required|in:cash,qris',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'alamat.required_if' => 'Alamat wajib diisi untuk pengiriman.',
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()
                ->with('error', 'Keranjang Anda kosong.');
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = $this->calculateTotal($cart);
            $totalBayar = $subtotal; // No delivery fee, same as subtotal

            // Create order
            $order = Order::create([
                'kode_order' => Order::generateOrderCode(),
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'nomor_hp' => $validated['nomor_hp'],
                'alamat' => $validated['alamat'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
                'metode_pengiriman' => $validated['metode_pengiriman'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'subtotal' => $subtotal,
                'total_bayar' => $totalBayar,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['id'],
                    'nama_menu' => $item['nama'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);
            }

            DB::commit();

            // Send WhatsApp notification for delivery orders
            if ($order->isDelivery()) {
                $whatsappService->sendNewDeliveryOrderNotification($order);
            }

            // Clear cart
            session()->forget('cart');

            return redirect()->route('checkout.success', $order->kode_order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Show order success page
     */
    public function success($kodeOrder)
    {
        $order = Order::where('kode_order', $kodeOrder)->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }

    /**
     * Calculate total from cart
     */
    protected function calculateTotal(array $cart): float
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return $total;
    }
}
