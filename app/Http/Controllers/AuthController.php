<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Http\Requests\SignUpFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Mail\UserVerification;
use App\Mail\ResetPassword;

class AuthController extends Controller
{   
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
                'status' => 'success',
                'data' => $user
            ]);
    }

    public function verification($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $user = User::find($check->user_id);
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();
            return redirect('/signin?q=verified');
        }
        return redirect('/signin?q=expired');
    }

    public function signup (SignUpFormRequest $request)
    {   

        # creating a new user object 
        $user = User::create([ 
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
            'profile_id' => str_random(64)
        ]);

        # sending user email verification
        $verification_code = str_random(30); 
        DB::table('user_verifications')->insert([
            'user_id' => $user->id, 
            'token' => $verification_code
        ]);
        Mail::to($user->email)->send(new UserVerification($verification_code));

        # return payload
        return response([ 
            'data' => $user
        ], 200);
    }

    public function signin (Request $request)
    { 
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if(!is_null($user)) { 
            if($user->is_verified == false || $user->isSuspended == true){ 
                return response([
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'msg' => 'Invalid Credentials.'
                ], 400);
            }
        }

        if (!$token = JWTAuth::attempt($credentials)) {
                return response([
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'msg' => 'Invalid Credentials.'
                ], 400);
        }
        return response([
                'status' => 'success'
            ])
            ->header('Authorization', $token);
    }

    public function refresh()
    {
        return response([
                'status' => 'success'
            ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
                'status' => 'success',
                'msg' => 'Logged out Successfully.'
            ], 200);
    }

    public function forgot(Request $request)
    { 
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) { 
            return response([ 
                'errors' => $validator->errors()
            ], 200);
        }

        $user = User::where('email', $request->email)->first(); 
        if (!is_null($user)) { 
            if(is_null($user->token) && !is_null($user->password)){ 
                $user->token = str_random(32);
                $user->password = ''; 
                $user->save();
                Mail::to($user->email)->send(new ResetPassword($user));
                return response([ 
                    'msg' => "The password for the account associated with this email address has been reset. Please check your email."
                ], 200);
            }
            return response([ 
                'msg' => "A reset link has already been sent to the email address."  
            ], 200);
        }
        return response([ 
            'msg' => "The email address entered isn't linked to an account."  
        ], 200);
    }

    public function reset(Request $request, $token)
    { 
        $validator = Validator::make($request->all(), [ 
            'password' => 'min:6|max:255|confirmed'
        ]);

        if ($validator->fails()) { 
            return response([ 
                'errors' => $validator->errors()
            ], 200);
        }

        $user = User::where('token', $token)->where('password', '')->where('is_verified', 1)->first(); 
        if (!is_null($user)) {
            /*$user->update(['password' => Hash::make($request->password)]);
            $user->update(['token' => '']);*/
            $user->setPassword($request->password);
            return response([ 
                'msg' => 'You have successfully changed your password.'
            ], 200);
        }
        if (is_null($user)) { 
            return response([ 
                'msg' => 'The password for this account has already been changed.'
            ], 200);
        }
    }

}
