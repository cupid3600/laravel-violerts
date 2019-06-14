<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\AirtableApiKey; 
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function suspend ($Id) 
    { 
    	$user = User::find($Id); 
    	if (!is_null($user)) { 
    		$user->isSuspended = true; 
    		$user->save();
    	}
    	return response([ 
    		'user' => $user
    	], 200);
    }

    public function restore ($Id)
    { 
    	$user = User::find($Id); 
    	if (!is_null($user)) { 
    		$user->isSuspended = false; 
    		$user->save();
    	}
    	return response([ 
    		'user' => $user
    	], 200);
    }

    # controller used to manage user groups 
    public function changeUserGroup (Request $request, $Id)
    { 
        $user = User::find($Id); 
        if (!is_null($request->user_group)) { 
            $user->user_group = $request->user_group; 
            $user->save(); 
        }
        return response($user->user_group, 200);
    }

    public function profile($token)
    { 
    	$user = User::where('profile_id', $token)->first(); 
    	return response([ 
    		'user' => $user
    	], 200);
    }

    public function addAirtableApiKey(Request $request, $Id)
    { 
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'key' => 'required|max:255|unique:airtable_api_key',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 200);
        }
        $user = User::find($Id); 
        if(!is_null($user)){ 
            $AirtableKeyExists = AirtableApiKey::where('key', $request->key)->get(); 
            if(count($AirtableKeyExists) === 0){ 
                $newAirtableKey = AirtableApiKey::create([ 
                    'user_id' => $user->id, 
                    'key' => $request->key,
                    'name' => $request->name
                ]);
                return response([ 
                    'success' => true
                ], 200);
            }
        }
        return response([ 
            'success' => true
        ], 200);
    }

    public function getAirtableApiKeys(Request $request, $Id)
    { 
        $user = User::find($Id); 
        if(!is_null($user)){ 
            return response($user->airtable_keys, 200);
        }
        return response(null, 200);
    }

    public function removeAirtableKey(Request $request, $Id)
    { 
        $AirtableAccount = AirtableApiKey::find($Id);
        $AirtableAccount->delete();
        return response([ 
            'success' => true
        ], 200);
    }
}
