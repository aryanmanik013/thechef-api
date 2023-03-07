<?php

namespace App\Mail\Kitchen;

use App\Model\Kitchen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
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
        return $this->subject('Welcome to Thechef')->view('mail.resetpassword')->with('Kitchen', $this->Kitchen);
    }
}
