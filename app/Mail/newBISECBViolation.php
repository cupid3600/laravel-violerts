<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newBISECBViolation extends Mailable
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
        return $this->markdown('mail.alerts.newBISECBViolation')
                    ->subject($this->property['address'].' - New ECB Violation')
                    ->with([ 
                        'property' => $this->property, 
                        'ecb_violation' => $this->ecb_violation
                    ]);
    }
}
