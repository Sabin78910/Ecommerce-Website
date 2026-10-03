<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        if (is_int($order)) {
            // Fetch the full order object using the ID
            $order = \App\Models\Order::find($order);
        }

        $this->order = $order;
    }

    public function build()
    {
        if (!$this->order || !isset($this->order->id)) {
            throw new \Exception("Order data is invalid.");
        }

        return $this->subject('Your Order Confirmation - Order #' . $this->order->id)
            ->view('emails.order-confirmation')
            ->with(['order' => $this->order]);
    }
}
