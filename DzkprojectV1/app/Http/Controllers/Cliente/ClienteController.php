<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\User;
use App\UserHasDiscount;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index($id){

      $user = User::find($id);

      $data = $user->discounts;

      return response()->json(['data'=> $data], 200);
    }

    public function detailUserDiscount($id){

       $data = UserHasDiscount::find($id)->with('discounts','discountsStatus','commerce','branch')->first();

       return response()->json(['data'=> $data], 200);
    }
}
