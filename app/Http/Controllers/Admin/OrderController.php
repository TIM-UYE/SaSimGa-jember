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
