<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newBISDOBViolation extends Mailable
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
        return $this->markdown('mail.alerts.newBISDOBViolation')
                    ->subject($this->property['address'].' - New DOB Violation')
                    ->with([ 
                        'property' => $this->property, 
                        'dob_violation' => $this->dob_violation
                    ]);
    }
}
