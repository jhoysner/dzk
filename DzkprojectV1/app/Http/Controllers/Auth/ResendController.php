<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;


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
    		return response()->json(['error'=>'User not found y/o User active'], 422);
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
            $message->subject('Inactive Account User');
        });

        return response()->json(['success'=>'Se ha enviado un correo para la activacion de la cuenta. Por favor revisa su correo'], 201);

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
    		return response()->json(['error'=>'User not found y/o User active'], 422);
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
            $message->subject('Unlocked User accounts');
        });

        return response()->json(['success'=>'Se ha enviado un correo para la activacion de la cuenta. Por favor revisa su correo'], 201);

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
            return response()->json(['error'=>'Token not valid'], 422);
        }

        $user->status = 1;
        $user->attempts = 0;
        $user->access_token = str_random(30);
        $user->save();

        return response()->json(['success'=>'Account user activate', 'user'=>$user], 200);
    }



}
