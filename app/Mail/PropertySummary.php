<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertySummary extends Mailable
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
        $this->complaints = $content['complaints']; 
        $this->dob_violations = $content['dob_violations']; 
        $this->ecb_violations = $content['ecb_violations']; 
        $this->job_applications = $content['job_applications'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.alerts.propertySummary')
                    ->subject($this->property['address'].' - Property Summary')
                    ->with([ 
                        'property'              =>      $this->property, 
                        'complaints'            =>      $this->complaints, 
                        'dob_violations'        =>      $this->dob_violations, 
                        'ecb_violations'        =>      $this->ecb_violations, 
                        'job_applications'      =>      $this->job_applications
                    ]);
    }
}
