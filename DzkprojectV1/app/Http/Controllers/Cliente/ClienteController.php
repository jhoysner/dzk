<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(){

      $user = User::all()->first();

      $data = $user->discounts;


      return response()->json(['data'=> $data], 200);
    }
}
