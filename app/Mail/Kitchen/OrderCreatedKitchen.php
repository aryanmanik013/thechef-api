<?php

namespace App\Mail\Kitchen;

use App\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreatedKitchen extends Mailable
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
        return $this->subject('Thechef : Order has been placed')->view('mail.Kitchen.order')->with('order', $this->order);
    }
}
