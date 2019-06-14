<?php

use App\User;
use App\Property; 
use App\Portfolio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [ 
        	[ 
        		'name' => 'Kemel McKenzie', 
        		'email' => 'kemel@violerts.com', 
        		'password' => Hash::make('Derplife@1'), 
                'user_group' => 2,
        		'is_verified' => 1
        	], 
            [ 
                'name' => 'Test User', 
                'email' => 'test@test.com', 
                'password' => Hash::make('Derplife@1'), 
                'is_verified' => 1
            ]
        ];

        $properties = [ 
            /*[ 
                'house_number' => '660', 
                'street_name' => 'MADISON AVENUE', 
                'borough' => 1, 
                'address' => '660 Madison Ave, New York, NY 10065', 
                'bin' => 104080, 
                'block' => 1375, 
                'lot' => 7502
            ]*/
        ];

        $portfolios = [ 
            /*[ 
                'user_id' => 1, 
                'property_id' => 1
            ]*/
        ];

        if(!is_null($users)){ 
        	foreach($users as $user){ 
        		User::create($user);
        	}
        }

        if(!is_null($properties)){ 
            foreach($properties as $property) { 
                Property::create($property);
            } 
        }

        if(!is_null($portfolios)){ 
            foreach($portfolios as $portfolio){ 
                Portfolio::create($portfolio);
            }
        }
    }
}
