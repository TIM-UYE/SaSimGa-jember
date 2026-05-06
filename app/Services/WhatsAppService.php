<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $token;
    protected ?string $groupId;
    protected string $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = config('services.fonnte.token', env('FONNTE_TOKEN', ''));
        $this->groupId = config('services.fonnte.group_id', env('FONNTE_GROUP_ID', null));
    }

    /**
     * Send message to WhatsApp group for new delivery orders
     */
    public function sendNewDeliveryOrderNotification(Order $order): bool
    {
        // Only send for delivery orders
        if (!$order->isDelivery()) {
            return false;
        }

        // Check if group ID is configured
        if (empty($this->groupId)) {
            Log::warning('FONNTE_GROUP_ID not configured. Cannot send WhatsApp notification.');
            return false;
        }

        // Check if token is configured
        if (empty($this->token)) {
            Log::warning('FONNTE_TOKEN not configured. Cannot send WhatsApp notification.');
            return false;
        }

        $message = $this->formatNewDeliveryOrderMessage($order);

        return $this->sendMessage($this->groupId, $message);
    }

    /**
     * Format message for new delivery order
     */
    protected function formatNewDeliveryOrderMessage(Order $order): string
    {
        $itemsList = '';
        foreach ($order->items as $item) {
            $itemsList .= "- {$item->nama_menu} ({$item->qty}x)\n";
        }

        $paymentInstruction = '';
        if ($order->isCashPayment()) {
            $paymentInstruction = "💰 Driver WAJIB membayar ke restoran:\n";
            $paymentInstruction .= "Rp" . number_format($order->subtotal, 0, ',', '.') . "\n\n";
            $paymentInstruction .= "💵 Driver menagip:\n";
            $paymentInstruction .= "- harga makanan\n";
            $paymentInstruction .= "- ongkos kirim customer\n";
        } else {
            $paymentInstruction = "✅ Makanan sudah dibayar via QRIS\n\n";
            $paymentInstruction .= "💵 Driver hanya menagip ongkos kirim customer\n";
        }

        $message = "🚨 ORDER DELIVERY BARU\n\n";
        $message .= "Order ID: {$order->kode_order}\n\n";
        $message .= "Customer:\n{$order->nama_pelanggan}\n\n";
        $message .= "Pesanan:\n{$itemsList}\n";
        $message .= "Subtotal makanan:\n";
        $message .= "Rp" . number_format($order->subtotal, 0, ',', '.') . "\n\n";
        $message .= $paymentInstruction;
        $message .= "Metode pembayaran:\n" . strtoupper($order->metode_pembayaran) . "\n\n";
        $message .= "Alamat:\n{$order->alamat}\n\n";

        if ($order->catatan) {
            $message .= "Catatan:\n{$order->catatan}\n\n";
        }

        return $message;
    }

    /**
     * Send message to a WhatsApp number or group
     */
    public function sendMessage(string $target, string $message): bool
    {
        if (empty($this->token)) {
            Log::error('FONNTE_TOKEN not configured');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/send-message", [
                'target' => $target,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Fonnte API response', [
                    'target' => $target,
                    'status' => $data['status'] ?? null,
                    'message' => $data['message'] ?? null,
                ]);
                return ($data['status'] ?? false) == true;
            }

            Log::error('Fonnte API error', [
                'target' => $target,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Fonnte API exception', [
                'target' => $target,
                'exception' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send message to customer
     */
    public function sendToCustomer(string $phoneNumber, string $message): bool
    {
        // Format phone number if needed
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        return $this->sendMessage($formattedPhone, $message);
    }

    /**
     * Format phone number to international format
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with 62, add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Check if service is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->token);
    }

    /**
     * Send order status update to customer
     */
    public function sendOrderStatusUpdate(Order $order): bool
    {
        if (empty($this->token)) {
            return false;
        }

        $statusLabels = Order::getStatusLabels();
        $status = $statusLabels[$order->status] ?? $order->status;

        $message = "📦 Update Status Pesanan\n\n";
        $message .= "Order ID: {$order->kode_order}\n";
        $message .= "Status: *{$status}*\n\n";

        if ($order->status === Order::STATUS_SIAP_DIAMBIL) {
            $message .= "Pesanan Anda sudah siap untuk diambil! 🎉\n";
        } elseif ($order->status === Order::STATUS_SELESAI) {
            $message .= "Terima kasih telah berbelanja! 🙏\n";
        } elseif ($order->status === Order::STATUS_DIBATALKAN) {
            $message .= "Pesanan Anda telah dibatalkan. 😔\n";
        }

        return $this->sendToCustomer($order->nomor_hp, $message);
    }
}
