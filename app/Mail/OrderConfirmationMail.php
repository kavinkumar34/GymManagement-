<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $items;
    public $shippingAddress;
    public $subtotal;
    public $shippingCharge;
    public $couponDiscount;
    public $couponCode;

    public function __construct(Order $order, $user, $items, $shippingAddress = null)
    {
        $this->order = $order;
        $this->user = $user;
        $this->items = $items;
        $this->shippingAddress = $shippingAddress;
        
        // Calculate subtotal using final_price if available
        $this->subtotal = 0;
        foreach ($items as $item) {
            $price = $item->final_price ?? $item->price ?? 0;
            $this->subtotal += $price * $item->quantity;
        }
        
        // Get shipping charge from order
        $this->shippingCharge = $order->shipping_charge ?? 0;
        
        // Get coupon details from payment_details
        $this->couponDiscount = 0;
        $this->couponCode = null;
        if ($order->payment_details) {
            try {
                $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                if (isset($paymentDetails['coupon_discount'])) {
                    $this->couponDiscount = floatval($paymentDetails['coupon_discount']);
                }
                if (isset($paymentDetails['coupon_code'])) {
                    $this->couponCode = $paymentDetails['coupon_code'];
                }
            } catch (\Exception $e) {}
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Order Confirmed - #' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}