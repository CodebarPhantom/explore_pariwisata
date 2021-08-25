<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingReceipt extends Mailable
{
    use Queueable, SerializesModels;

    protected $detailsReceipt;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detailsReceipt)
    {
        $this->detailsReceipt = $detailsReceipt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@ulinyu.id', 'Ulinyu')
            ->subject($this->detailsReceipt['subject'])
            ->view('frontend.mail.new_booking')->with(['detailReceipt'=>$this->detailsReceipt]);
    }
}
