<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BISComplaintStatus extends Mailable
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
        $this->complaint = $content['complaint'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.alerts.BISComplaintStatus')
                    ->subject($this->property['address'].' - Complaint Update')
                    ->with([ 
                        'property' => $this->property, 
                        'complaint' => $this->complaint
                    ]);
    }
}
