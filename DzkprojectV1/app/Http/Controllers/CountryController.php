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
    		'name' => 'Selecciona Pais'
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
    		'name' => 'Selecciona Estado'
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
    		'name' => 'Selecciona Ciudad'
    	];

    	foreach ($cities as $key => $value) {
    		$data[$key+1] = [
    			'id' => $value->idcity,
    			'name' => $value->name
    		];
    	}
    	
    	return response()->json($data);

    }
}
