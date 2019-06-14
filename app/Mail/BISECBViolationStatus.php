<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BISECBViolationStatus extends Mailable
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
        $this->ecb_violation = $content['ecb_violation'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.alerts.BISECBViolationStatus')
                    ->subject($this->property['address'].' - ECB Violation Update')
                    ->with([ 
                        'property' => $this->property, 
                        'ecb_violation' => $this->ecb_violation
                    ]);;
    }
}
