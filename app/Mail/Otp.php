<?php

namespace App\Mail;

use App\Model\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class Otp extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Please Verify OTP')->view('mail.otp')->with('customer', $this->customer);
    }
}
