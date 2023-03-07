<?php

namespace App\Mail\Kitchen;

use App\Model\Kitchen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
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
        //dd($Kitchen);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Welcome To Thechef')->view('mail.Kitchen.register')->with('Kitchen', $this->Kitchen);

    }
}
