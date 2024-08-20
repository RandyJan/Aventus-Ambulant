<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InvoicePulloutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payload;
    /**
     * Create a new message instance.
     *
     * @param array $payload
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.invoice-pullout')
            ->subject('Pullout Slip');
    }
}
