<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newBISComplaint extends Mailable
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
        return $this->markdown('mail.alerts.newBISComplaint')
                    ->subject($this->property['address'].' - New Complaint')
                    ->with([ 
                        'property' => $this->property, 
                        'complaint' => $this->complaint
                    ]);
    }
}
