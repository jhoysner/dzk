<?php

namespace App\Http\Controllers\Auth;

use App\User;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Lang;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'country_id' => 'required|string',
            'state_id' => 'required|string',
            'city_id' => 'required|string'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country_idcountry' => $data['country_id'],
            'state_idstate' => $data['state_id'],
            'city_idcity' => $data['city_id'],
        ]);

        return $user;
    }


    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $request['access_token'] = str_random(30);

        $user = DB::table('users')->insertGetId(
            array(
                'id' => bin2hex(random_bytes(15)),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'access_token' => $request->access_token,
                'country_idcountry'=>$request->country_id,
                'state_idstate'=>$request->state_id,
                'city_idcity'=>$request->city_id,
                'created_at'=> Carbon::now()->toDateTimeString()
                )
        );

        $data = [
            'email' => $request->email,
            'firstname' =>  $request->firstname,
            'lastname' => $request->lastname,
            'access_token' => $request->access_token
        ];

        Mail::send('email.registro', $data, function($message) use ($data) {
            $message->from(\Config::get('mail.from.address'),\Config::get('mail.from.name'));
            $message->to($data['email']);
            $message->subject(\Lang::get('messages.activate_account'));
        });

        return response()->json(['success'=>\Lang::get('messages.email_activation')], 201);
    }


    public function emailValidation($code) 
    {
        return view('auth.activation');
    }

    public function activationAccount(Request $request) 
    {
        $token = $request->token;

        $user = User::where('access_token','=', $token)->first();

        if(!$user) {
            return response()->json(['error'=>\Lang::get('messages.token_invalid')], 422);
        }

        $user->status = 1;
        $user->access_token = str_random(30);
        $user->save();

        return response()->json(['success'=>\Lang::get('messages.account_active'), 'user'=>$user], 200);
    }


    




}
