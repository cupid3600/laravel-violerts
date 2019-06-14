<?php

namespace App\Jobs;

use App\User; 
use Mail; 
use App\Property; 
use App\BISECBViolation; 
use App\Mail\newBISECBViolation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class newBISECBViolationAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $content; 
    public $timeout = 120; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->content = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->content['user']->email)->send(new newBISECBViolation($this->content));
    }
}
