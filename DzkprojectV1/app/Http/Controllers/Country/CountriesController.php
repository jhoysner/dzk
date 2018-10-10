<?php

namespace App\Http\Controllers\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Country;
use App\State;
use App\City;

class CountriesController extends Controller
{
  public function getCountries()
  {
    $countries = Country::all();

    $data = [];

    $data[0] = [
      'id' => '',
      'name' => 'Seleccione Pais'
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
      'id' => '',
      'name' => 'Seleccione Estado'
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
      'id' => '',
      'name' => 'Seleccione Ciudad'
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
