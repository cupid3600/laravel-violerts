<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BISJobApplicationStatus extends Mailable
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
        $this->job_application = $content['job_application'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.alerts.BISJobApplicationStatus')
                    ->subject($this->property['address'].' - Job Application Status Update')
                    ->with([ 
                        'property' => $this->property, 
                        'job_application' => $this->job_application
                    ]);
    }
}
