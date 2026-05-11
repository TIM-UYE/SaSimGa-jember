<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

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

        // Filter by status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Filter by payment status
        if ($paymentStatus !== 'all') {
            $query->where('payment_status', $paymentStatus);
        }

        // Search by order code or customer name
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
     * Update order status
     */
    public function updateStatus(Request $request, Order $order, WhatsAppService $whatsappService)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,siap_diambil,diantar,selesai,dibatalkan',
        ]);

        $oldStatus = $order->status;
        $order->status = $validated['status'];
        $order->save();

        // Auto set payment status to paid when order is completed
        if ($validated['status'] === Order::STATUS_SELESAI && $order->payment_status === Order::PAYMENT_UNPAID) {
            $order->payment_status = Order::PAYMENT_PAID;
            $order->save();
        }

        // Cancel order - revert payment status
        if ($validated['status'] === Order::STATUS_DIBATALKAN) {
            $order->payment_status = Order::PAYMENT_UNPAID;
            $order->save();
        }

        // Send WhatsApp notification to customer for certain status changes
        if (in_array($validated['status'], [Order::STATUS_SIAP_DIAMBIL, Order::STATUS_SELESAI, Order::STATUS_DIBATALKAN])) {
            $whatsappService->sendOrderStatusUpdate($order);
        }

        // If AJAX request, return JSON response
        if ($request->expectsJson() || $request->ajax()) {
            $statusLabels = Order::getStatusLabels();
            $paymentStatusLabels = Order::getPaymentStatusLabels();
            $nextStatus = $order->getNextStatus();
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
                'siap_diambil' => Order::where('status', Order::STATUS_SIAP_DIAMBIL)->count(),
                'selesai' => Order::where('status', Order::STATUS_SELESAI)->count(),
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

        $order->payment_status = $validated['payment_status'];
        $order->save();

        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diubah!');
    }

    /**
     * AJAX Polling endpoint - returns JSON with updated orders data for auto-refresh
     */
    public function pollData(Request $request)
    {
        $status = $request->get('status', 'all');
        $paymentStatus = $request->get('payment_status', 'all');
        $search = $request->get('search', '');

        $query = Order::with('items')->latest();

        // Apply same filters as index
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

        $orders = $query->take(50)->get(); // Limit for polling performance

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
                // Debug info for progress steps
                'flow_keys' => array_keys($statusFlow),
            ];
        });

        // Stats for dashboard cards
        $stats = [
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'diproses' => Order::where('status', Order::STATUS_DIPROSES)->count(),
            'siap_diambil' => Order::where('status', Order::STATUS_SIAP_DIAMBIL)->count(),
            'selesai' => Order::where('status', Order::STATUS_SELESAI)->count(),
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
            'processing_orders' => Order::whereIn('status', [Order::STATUS_DIPROSES, Order::STATUS_SIAP_DIAMBIL])->count(),
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
     * Destroy an order (soft delete - just mark as cancelled)
     */
    public function destroy(Order $order)
    {
        $order->status = Order::STATUS_DIBATALKAN;
        $order->payment_status = Order::PAYMENT_UNPAID;
        $order->save();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
