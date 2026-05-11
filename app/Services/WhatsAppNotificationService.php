<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    protected WhatsAppService $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Send status update notification to customer
     */
    public function sendStatusUpdate(Order $order, string $status): bool
    {
        $messages = $this->getStatusMessages();

        if (!isset($messages[$status])) {
            Log::warning("No WhatsApp message defined for status: {$status}");
            return false;
        }

        $message = $this->formatMessage($messages[$status], $order);

        return $this->whatsappService->sendToCustomer($order->nomor_hp, $message);
    }

    /**
     * Get status update messages
     */
    protected function getStatusMessages(): array
    {
        return [
            Order::STATUS_PENDING => "Halo {nama_pelanggan}, pesanan Anda sedang menunggu konfirmasi restoran.",
            Order::STATUS_DIPROSES => "Halo {nama_pelanggan}, pesanan Anda sedang diproses oleh restoran.",
            Order::STATUS_DIMASAK => "Pesanan Anda sedang dimasak 👨‍🍳",
            Order::STATUS_SIAP_DIAMBIL => "Pesanan Anda sudah siap diambil di restoran.",
            Order::STATUS_DIANTAR => "Pesanan Anda sedang diantar driver.",
            Order::STATUS_SELESAI => "Pesanan selesai. Terima kasih telah memesan ❤️",
        ];
    }

    /**
     * Format message with order data
     */
    protected function formatMessage(string $template, Order $order): string
    {
        return str_replace(
            ['{nama_pelanggan}', '{order_id}'],
            [$order->nama_pelanggan, $order->kode_order],
            $template
        );
    }
}
