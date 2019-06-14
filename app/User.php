<?php

namespace App;

use Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable, CanResetPassword;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey(); // Eloquent Model method
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'is_verified', 'isSuspended', 'profile_id', 'user_group', 'mobile_phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verified()
    {
        if($this->is_verified == true){ 
            return false;
        }
      
        if($this->is_verified == false){ 
            $this->is_verified = 1;
            $this->save();
            return true;
        }
    }

    public function portfolio () 
    { 
        return $this->hasMany('App\Portfolio');
    }

    public function airtable_keys ()
    { 
        return $this->hasMany('App\AirtableApiKey');
    }

    public function setPassword ($password)
    { 
        $this->attributes['password'] = Hash::make($password);
        $this->attributes['token'] = null;    
    }
}
