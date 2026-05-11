<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $paymentStatus = $request->get('payment_status', 'all');
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 15);

        $query = Order::with('items')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($paymentStatus !== 'all') {
            $query->where('payment_status', $paymentStatus);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_order', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nomor_hp', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate($perPage)->withQueryString();

        $statusLabels = Order::getStatusLabels();
        $paymentStatusLabels = Order::getPaymentStatusLabels();
        $deliveryMethodLabels = Order::getDeliveryMethodLabels();
        $paymentMethodLabels = Order::getPaymentMethodLabels();

        return view('admin.orders.index', compact(
            'orders',
            'status',
            'paymentStatus',
            'search',
            'statusLabels',
            'paymentStatusLabels',
            'deliveryMethodLabels',
            'paymentMethodLabels'
        ));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['items', 'paymentTransactions']);

        $statusLabels = Order::getStatusLabels();
        $paymentStatusLabels = Order::getPaymentStatusLabels();
        $deliveryMethodLabels = Order::getDeliveryMethodLabels();
        $paymentMethodLabels = Order::getPaymentMethodLabels();

        return view('admin.orders.show', compact('order', 'statusLabels', 'paymentStatusLabels', 'deliveryMethodLabels', 'paymentMethodLabels'));
    }

    /**
     * Update order status with database transaction, logging, and WhatsApp notification.
     *
     * Flow:
     * 1. Validate request
     * 2. Check if status actually changed (prevent duplicate)
     * 3. DB transaction: save order + payment status + history
     * 4. Send WhatsApp notification (outside transaction to avoid slow API blocking DB)
     * 5. Log everything
     */
    public function updateStatus(Request $request, Order $order, WhatsAppService $whatsappService)
    {
        // 1. Validate request
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,dimasak,siap_diambil,diantar,selesai,dibatalkan',
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $order->status;

        // 2. Prevent duplicate — if status hasn't changed, reject
        if ($newStatus === $oldStatus) {
            Log::warning('[ORDER DUPLICATE] Status sama, tolak request', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'status' => $oldStatus,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status pesanan sudah "' . ($order->getStatusLabels()[$newStatus] ?? $newStatus) . '". Tidak ada perubahan.',
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Status pesanan sudah "' . ($order->getStatusLabels()[$newStatus] ?? $newStatus) . '". Tidak ada perubahan.');
        }

        // Prevent rollback to previous status (should be handled by canChangeToStatus, but double-check)
        if (!$order->canChangeToStatus($newStatus)) {
            Log::warning('[ORDER INVALID] Perubahan status tidak diizinkan', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perubahan status tidak diizinkan.',
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Perubahan status tidak diizinkan.');
        }

        // 3. DB Transaction — save changes atomically
        try {
            DB::beginTransaction();

            // Update order status
            $order->status = $newStatus;
            $order->save();

            // Auto set payment status to paid when order is completed
            if ($newStatus === Order::STATUS_SELESAI && $order->payment_status === Order::PAYMENT_UNPAID) {
                $order->payment_status = Order::PAYMENT_PAID;
                $order->save();
                Log::info('[ORDER PAYMENT] Pembayaran otomatis di-set ke paid karena status selesai', [
                    'order_id' => $order->id,
                    'kode_order' => $order->kode_order,
                ]);
            }

            // Cancel order — revert payment status
            if ($newStatus === Order::STATUS_DIBATALKAN) {
                $order->payment_status = Order::PAYMENT_UNPAID;
                $order->save();
                Log::info('[ORDER CANCEL] Pembayaran dikembalikan ke unpaid karena dibatalkan', [
                    'order_id' => $order->id,
                    'kode_order' => $order->kode_order,
                ]);
            }

            // Log status change ke tabel history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $newStatus,
                'previous_status' => $oldStatus,
                'changed_by' => auth()->id(),
                'metadata' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'changed_from' => 'admin_panel',
                ],
            ]);

            DB::commit();

            Log::info('[ORDER SUCCESS] Status berhasil diubah', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->id(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('[ORDER DB FAIL] Gagal menyimpan perubahan status', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan perubahan status. Silakan coba lagi.',
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menyimpan perubahan status. Silakan coba lagi.');
        }

        // 4. Send WhatsApp notification (outside transaction — API call should not block DB)
        // Only send for certain status changes: dimasak, siap_diambil, diantar, selesai, dibatalkan
        $waStatuses = [
            Order::STATUS_DIMASAK,
            Order::STATUS_SIAP_DIAMBIL,
            Order::STATUS_DIANTAR,
            Order::STATUS_SELESAI,
            Order::STATUS_DIBATALKAN,
        ];

        if (in_array($newStatus, $waStatuses)) {
            try {
                $waResult = $whatsappService->sendOrderStatusUpdate($order);

                if ($waResult) {
                    Log::info('[ORDER WA SUCCESS] Notifikasi WA berhasil dikirim', [
                        'order_id' => $order->id,
                        'kode_order' => $order->kode_order,
                        'status' => $newStatus,
                    ]);
                } else {
                    Log::warning('[ORDER WA FAIL] Notifikasi WA gagal dikirim (service return false)', [
                        'order_id' => $order->id,
                        'kode_order' => $order->kode_order,
                        'status' => $newStatus,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('[ORDER WA EXCEPTION] Exception saat kirim notifikasi WA', [
                    'order_id' => $order->id,
                    'kode_order' => $order->kode_order,
                    'status' => $newStatus,
                    'exception' => $e->getMessage(),
                ]);
                // DO NOT rollback — status sudah tersimpan, notifikasi gagal adalah non-critical
            }
        } else {
            Log::info('[ORDER WA SKIP] Status tidak termasuk dalam daftar kirim WA', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'status' => $newStatus,
                'wa_statuses' => $waStatuses,
            ]);
        }

        // 5. Return response
        if ($request->expectsJson() || $request->ajax()) {
            $statusLabels = Order::getStatusLabels();
            $paymentStatusLabels = Order::getPaymentStatusLabels();
            $nextStatus = $order->fresh()->getNextStatus();
            $statusFlow = $order->getStatusFlow();
            $currentIndex = array_search($order->status, array_keys($statusFlow));

            $orderData = [
                'id' => $order->id,
                'kode_order' => $order->kode_order,
                'nama_pelanggan' => $order->nama_pelanggan,
                'nomor_hp' => $order->nomor_hp,
                'metode_pengiriman' => $order->metode_pengiriman,
                'metode_pembayaran' => $order->metode_pembayaran,
                'total_bayar' => number_format($order->total_bayar, 0, ',', '.'),
                'total_bayar_raw' => (float) $order->total_bayar,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'status_label' => $statusLabels[$order->status] ?? $order->status,
                'payment_status_label' => $paymentStatusLabels[$order->payment_status] ?? $order->payment_status,
                'status_color' => $order->getStatusColor(),
                'status_icon' => $order->getStatusIcon(),
                'next_status' => $nextStatus,
                'next_status_label' => $nextStatus ? ($statusLabels[$nextStatus] ?? $nextStatus) : null,
                'is_active' => $order->isActive(),
                'created_at' => $order->created_at->format('d M Y, H:i'),
                'detail_url' => route('admin.orders.show', $order),
                'status_flow' => $statusFlow,
                'current_index' => $currentIndex,
                'flow_keys' => array_keys($statusFlow),
            ];

            $stats = [
                'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
                'diproses' => Order::where('status', Order::STATUS_DIPROSES)->count(),
                'dimasak' => Order::where('status', Order::STATUS_DIMASAK)->count(),
                'siap_diambil' => Order::where('status', Order::STATUS_SIAP_DIAMBIL)->count(),
                'selesai' => Order::where('status', Order::STATUS_SELESAI)->count(),
                'dibatalkan' => Order::where('status', Order::STATUS_DIBATALKAN)->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diubah!',
                'order' => $orderData,
                'stats' => $stats,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diubah!');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        try {
            $order->payment_status = $validated['payment_status'];
            $order->save();

            Log::info('[ORDER PAYMENT] Status pembayaran diubah', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'payment_status_baru' => $validated['payment_status'],
                'changed_by' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            Log::error('[ORDER PAYMENT FAIL] Gagal update status pembayaran', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'exception' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengubah status pembayaran.');
        }

        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diubah!');
    }

    /**
     * AJAX Polling endpoint — returns JSON with updated orders data for auto-refresh
     * This is READ-ONLY. It does NOT trigger any status changes or WhatsApp notifications.
     */
    public function pollData(Request $request)
    {
        $status = $request->get('status', 'all');
        $paymentStatus = $request->get('payment_status', 'all');
        $search = $request->get('search', '');

        $query = Order::with('items')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }
        if ($paymentStatus !== 'all') {
            $query->where('payment_status', $paymentStatus);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_order', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nomor_hp', 'like', "%{$search}%");
            });
        }

        $orders = $query->take(50)->get();

        $statusLabels = Order::getStatusLabels();
        $paymentStatusLabels = Order::getPaymentStatusLabels();

        $ordersData = $orders->map(function ($order) use ($statusLabels, $paymentStatusLabels) {
            $nextStatus = $order->getNextStatus();
            $statusFlow = $order->getStatusFlow();
            $currentIndex = array_search($order->status, array_keys($statusFlow));

            return [
                'id' => $order->id,
                'kode_order' => $order->kode_order,
                'nama_pelanggan' => $order->nama_pelanggan,
                'nomor_hp' => $order->nomor_hp,
                'metode_pengiriman' => $order->metode_pengiriman,
                'metode_pembayaran' => $order->metode_pembayaran,
                'total_bayar' => number_format($order->total_bayar, 0, ',', '.'),
                'total_bayar_raw' => (float) $order->total_bayar,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'status_label' => $statusLabels[$order->status] ?? $order->status,
                'payment_status_label' => $paymentStatusLabels[$order->payment_status] ?? $order->payment_status,
                'status_color' => $order->getStatusColor(),
                'status_icon' => $order->getStatusIcon(),
                'next_status' => $nextStatus,
                'next_status_label' => $nextStatus ? ($statusLabels[$nextStatus] ?? $nextStatus) : null,
                'is_active' => $order->isActive(),
                'created_at' => $order->created_at->format('d M Y, H:i'),
                'detail_url' => route('admin.orders.show', $order),
                'status_flow' => $statusFlow,
                'current_index' => $currentIndex,
                'flow_keys' => array_keys($statusFlow),
            ];
        });

        $stats = [
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'diproses' => Order::where('status', Order::STATUS_DIPROSES)->count(),
            'dimasak' => Order::where('status', Order::STATUS_DIMASAK)->count(),
            'siap_diambil' => Order::where('status', Order::STATUS_SIAP_DIAMBIL)->count(),
            'selesai' => Order::where('status', Order::STATUS_SELESAI)->count(),
            'dibatalkan' => Order::where('status', Order::STATUS_DIBATALKAN)->count(),
        ];

        return response()->json([
            'success' => true,
            'orders' => $ordersData,
            'stats' => $stats,
        ]);
    }

    /**
     * Get order statistics for dashboard
     */
    public function stats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'processing_orders' => Order::whereIn('status', [Order::STATUS_DIPROSES, Order::STATUS_DIMASAK, Order::STATUS_SIAP_DIAMBIL])->count(),
            'completed_orders' => Order::where('status', Order::STATUS_SELESAI)->count(),
            'cancelled_orders' => Order::where('status', Order::STATUS_DIBATALKAN)->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', Order::STATUS_SELESAI)
                ->sum('total_bayar'),
        ];

        return response()->json($stats);
    }

    /**
     * Destroy an order (soft delete — mark as cancelled)
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            $order->status = Order::STATUS_DIBATALKAN;
            $order->payment_status = Order::PAYMENT_UNPAID;
            $order->save();

            // Log ke history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => Order::STATUS_DIBATALKAN,
                'previous_status' => $order->getOriginal('status'),
                'changed_by' => auth()->id(),
                'metadata' => [
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'changed_from' => 'admin_destroy',
                ],
            ]);

            DB::commit();

            Log::info('[ORDER DESTROY] Pesanan dibatalkan via destroy', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('[ORDER DESTROY FAIL] Gagal membatalkan pesanan', [
                'order_id' => $order->id,
                'kode_order' => $order->kode_order,
                'exception' => $e->getMessage(),
            ]);

            return redirect()->route('admin.orders.index')
                ->with('error', 'Gagal membatalkan pesanan.');
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
