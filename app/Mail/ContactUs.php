<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    private $messenger;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messenger)
    {
        $this->messenger = $messenger;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contactUs', ["messenger"=>$this->messenger]);
    }
}
