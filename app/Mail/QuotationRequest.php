<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    Public
        $productID,
        $productName,
        $requesterName,
        $requesterLastName,
        $requesterMail,
        $requestSpecifications;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productID, $productName, $requesterName, $requesterLastName, $requesterMail, $requestSpecifications) {
        $this->productID = $productID;
        $this->productName = $productName;
        $this->requesterName = $requesterName;
        $this->requesterLastName = $requesterLastName;
        $this->requesterMail = $requesterMail;
        $this->requestSpecifications = $requestSpecifications;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.quotation-request');
    }
}
