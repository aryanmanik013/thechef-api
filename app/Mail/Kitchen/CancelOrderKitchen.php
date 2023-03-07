<?php

namespace App\Mail\Kitchen;

use App\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrderKitchen extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cancel Order ' . $this->order->invoice_prefix . $this->order->id . ' has been Cancelled')->view('mail.Kitchen.orderCancel')->with('order', $this->order);

    }
}
