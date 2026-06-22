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

    public function __construct(Order $order, $user, $items, $shippingAddress = null)
    {
        $this->order = $order;
        $this->user = $user;
        $this->items = $items;
        $this->shippingAddress = $shippingAddress;
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