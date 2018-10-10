<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;
use Lang;

class ResendController extends Controller
{
    
    public function showResendEmailForm()
    {
        return view('user.resendemail');
    }

    public function resendEmail(Request $request) 
    {	
    	$email = $request->email;
    	
    	$user = User::where('email','=', $email)
    				->where('status','=', 0)
    				->first();

    	if(!$user)
    	{
    		return response()->json(['error'=>\Lang::get('messages.user_notfound')], 422);
    	} 

    	$user->access_token = str_random(30);
        $user->save();

        $data = [
            'email' => $user->email,
            'firstname' =>  $user->firstname,
            'lastname' => $user->lastname,
            'access_token' => $user->access_token
        ];

        Mail::send('email.registro', $data, function($message) use ($data) {
            $message->from(\Config::get('mail.from.address'),\Config::get('mail.from.name'));
            $message->to($data['email']);
            $message->subject(\Lang::get('messages.account_notactive'));
        });

        return response()->json(['success'=>\Lang::get('messages.email_activation')], 201);

    }

    public function showUnlockedEmailForm()
    {
    	return view('user.emailunlocked');
    }

    public function unlockedEmail(Request $request)
    {
		$email = $request->email;
    	
    	$user = User::where('email','=', $email)
    				->where('status','=', 0)
    				->first();

    	if(!$user)
    	{
    		return response()->json(['error'=>\Lang::get('messages.user_foundoract')], 422);
    	} 

    	$user->access_token = str_random(30);
        $user->save();

        $data = [
            'email' => $user->email,
            'firstname' =>  $user->firstname,
            'lastname' => $user->lastname,
            'access_token' => $user->access_token
        ];

        Mail::send('email.unlocked', $data, function($message) use ($data) {
            $message->from(\Config::get('mail.from.address'),\Config::get('mail.from.name'));
            $message->to($data['email']);
            $message->subject(\Lang::get('messages.user_unlocked'));
        });

        return response()->json(['success'=>\Lang::get('messages.email_activation')], 201);

    }

    public function unlockedAccount($code) 
    {
        return view('auth.unlocked');
    }

    public function accountUnlock(Request $request) 
    {
        $token = $request->token;

        $user = User::where('access_token','=', $token)->first();

        if(!$user) {
            return response()->json(['error'=>\Lang::get('messages.token_invalid')], 422);
        }

        $user->status = 1;
        $user->attempts = 0;
        $user->access_token = str_random(30);
        $user->save();

        return response()->json(['success'=>\Lang::get('messages.account_active'), 'user'=>$user], 200);
    }



}
