<?php

namespace App\Console\Commands;


use App\User; 
use Illuminate\Console\Command;

class makeUserProfileID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:userprofileid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates profile id values for existing users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users = User::where('profile_id', null)->get();
        if(count($users) > 0){ 
            foreach($users as $user){ 
                $user->profile_id = str_random(64); 
                $user->save();
            }
        }
    }
}
