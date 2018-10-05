<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\City;
//use Illuminate\Mail\Message;
//use Illuminate\Support\Facades\Mail;
use Mail;

class CountryController extends Controller
{
    public function getCountries()
    {
    	$countries = Country::all();

    	$data = [];

    	$data[0] = [
    		'id' => 0,
    		'name' => 'Select Country'
    	];

    	foreach ($countries as $key => $value) {
    		$data[$key+1] = [
    			'id' => $value->idcountry,
    			'name' => $value->name
    		];
    	}

    	return response()->json($data);
    }

    public function getStates($id)
    {
    	$states = State::where('country_idcountry','=',$id)->get();

		$data = [];

    	$data[0] = [
    		'id' => 0,
    		'name' => 'Select State'
    	];

    	foreach ($states as $key => $value) {
    		$data[$key+1] = [
    			'id' => $value->idstate,
    			'name' => $value->name
    		];
    	}    
    	
    	return response()->json($data);

    }

    public function getCities($id)
    {
    	$cities = City::where('state_idstate','=',$id)->get();

		$data = [];

    	$data[0] = [
    		'id' => 0,
    		'name' => 'Select City'
    	];

    	foreach ($cities as $key => $value) {
    		$data[$key+1] = [
    			'id' => $value->idcity,
    			'name' => $value->name
    		];
    	}
    	
    	return response()->json($data);

    }

public function prueba()
{
    $data = [
            'email' => 'p@example.com',
            'firstname' =>  'Benito',
            'lastname' => 'Perez',
            'access_token' => '12dddd'
        ];

    Mail::send('email.registro', $data, function($message) use ($data) {
            $message->from(\Config::get('mail.from.address'),\Config::get('mail.from.name'));
            $message->to($data['email']);
            $message->subject('Activate you users accounts');
        });
}
}
