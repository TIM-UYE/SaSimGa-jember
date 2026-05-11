<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\WhatsAppService;
use App\Services\WhatsAppNotificationService;
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
    public function store(Request $request, WhatsAppService $whatsappService, WhatsAppNotificationService $whatsappNotificationService)
    {
        // Validate input
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'catatan' => 'nullable|string|max:1000',
            'metode_pengiriman' => 'required|in:pickup,delivery',
            'metode_pembayaran' => 'required|in:cash,qris',
            // Address fields validation based on delivery method
            'alamat' => 'nullable|string|max:500',
            'alamat_method' => 'nullable|in:location,manual',
            'alamat_qris_location' => 'nullable|string|max:500',
            'alamat_qris_manual' => 'nullable|string|max:500',
            'latitude_cash' => 'nullable|numeric',
            'longitude_cash' => 'nullable|numeric',
            'latitude_qris' => 'nullable|numeric',
            'longitude_qris' => 'nullable|numeric',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        // Validate address based on delivery method and payment method
        if ($validated['metode_pengiriman'] === 'delivery') {
            if ($validated['metode_pembayaran'] === 'cash') {
                // For CASH: Address must be filled (from geolocation)
                if (empty($validated['alamat'])) {
                    return redirect()->back()
                        ->withErrors(['alamat' => 'Alamat wajib diambil menggunakan lokasi terkini untuk pembayaran CASH.'])
                        ->withInput();
                }
            } elseif ($validated['metode_pembayaran'] === 'qris') {
                // For QRIS: Either location or manual address must be filled
                $addressMethod = $validated['alamat_method'] ?? null;

                if ($addressMethod === 'location') {
                    if (empty($validated['alamat_qris_location'])) {
                        return redirect()->back()
                            ->withErrors(['alamat_qris_location' => 'Silakan ambil lokasi terkini Anda.'])
                            ->withInput();
                    }
                    $alamatFinal = $validated['alamat_qris_location'];
                } elseif ($addressMethod === 'manual') {
                    if (empty($validated['alamat_qris_manual'])) {
                        return redirect()->back()
                            ->withErrors(['alamat_qris_manual' => 'Silakan isi alamat pengiriman Anda.'])
                            ->withInput();
                    }
                    $alamatFinal = $validated['alamat_qris_manual'];
                } else {
                    return redirect()->back()
                        ->withErrors(['alamat' => 'Silakan pilih metode alamat (lokasi terkini atau manual).'])
                        ->withInput();
                }
            }
        } else {
            // For pickup, no address needed
            $alamatFinal = null;
        }

        // Use appropriate address field
        if ($validated['metode_pengiriman'] === 'delivery') {
            if ($validated['metode_pembayaran'] === 'cash') {
                $alamatFinal = $validated['alamat'];
            } elseif ($validated['metode_pembayaran'] === 'qris') {
                $alamatMethod = $validated['alamat_method'] ?? null;
                $alamatFinal = ($addressMethod === 'location') ? $validated['alamat_qris_location'] : $validated['alamat_qris_manual'];
            }
        } else {
            $alamatFinal = null;
        }

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
                'alamat' => $alamatFinal,
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

            // Send WhatsApp notification to customer about order created
            try {
                $whatsappNotificationService->sendOrderCreated($order);
            } catch (\Exception $e) {
                // Log error but don't fail the checkout
                \Illuminate\Support\Facades\Log::error('Failed to send order created WA notification', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Clear cart
            session()->forget('cart');

            // If QRIS payment, redirect to Snap payment page
            if ($order->isQRISPayment()) {
                return redirect()->route('payment.snap', $order->kode_order);
            }

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
