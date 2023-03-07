<?php

namespace App\Mail\Kitchen;

use App\Model\Kitchen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class Otp extends Mailable
{
    use Queueable, SerializesModels;

    protected $Kitchen;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Kitchen $Kitchen)
    {
        $this->Kitchen = $Kitchen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Please Verify OTP')->view('mail.Kitchen.otp')->with('Kitchen', $this->Kitchen);
    }
}
