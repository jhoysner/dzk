<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Params;
use Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function numberLoginAttemps($data)
    {
        $attempts = Params::where('key','=','user_login_max_attempts')->first(); 
        
        $attempt = $attempts? $attempts['val']: 4;    

        $user = $this->userData($data); 

        $numberAttemptsUser = $user['attempts'];

        return $numberAttemptsUser > $attempt;

    }

    protected function userData($email)
    {
        $user = User::where('email','=',$email)->first();

        if(!$user) {
            return false;
        }

        return $user;        
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only('email','password');

        $user = $this->userData($credentials['email']);
 
        if(!$user) {
            return response()->json(['state'=>'Not_Found','error'=>\Lang::get('messages.user_notfound')], 404);
        }

        if(isset($user->delete)) {
            return response()->json(['state'=>'Canceled','error'=>\Lang::get('messages.account_canceled')], 422);
        }

        if($user->status == 0 && is_null($user->lastlogin) && is_null($user->delete_at)) {
            return response()->json(['state'=>'Inactive','error'=>\Lang::get('messages.account_notactive')], 422);
        }

        if($user->status == 0 && isset($user->lastlogin) && is_null($user->delete_at)) {
            return response()->json(['state'=>'Locked','error'=>\Lang::get('messages.account_locked')], 422);
        }

        if($this->numberLoginAttemps($user->email)) {
            $user->status = 0;
            $user->save();
            return response()->json(['state'=>'Attempts','error'=>'Account to many attempts access'], 422);            
        } 

        if (Auth::attempt($credentials)) {
            return response()->json(['state'=>'Active','success'=>'Successful session start','user' => Auth::user()], 200);
        } 

        return response()->json(['state'=>'Invalid','error'=>\Lang::get('messages.credential_invalid')], 422);            
        
    }

    public function authenticateold(Request $request)
    {
        dd($request->all());
         if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'] ])) {
            return redirect('home');
        }
        return redirect('login');
    }
    
}
