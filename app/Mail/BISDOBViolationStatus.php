<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BISDOBViolationStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        //
        $this->content = $content;
        $this->property = $content['property']; 
        $this->dob_violation = $content['dob_violation'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.BISDOBViolationStatus')
                    ->subject($this->property['address'].' - DOB Violation Update')
                    ->with([ 
                        'property' => $this->property, 
                        'dob_violation' => $this->dob_violation
                    ]);
    }
}
