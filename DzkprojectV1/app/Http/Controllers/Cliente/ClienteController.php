<?php

namespace App\Http\Controllers\Cliente;

use App\Discount;
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

       $data = UserHasDiscount::where('idusers_has_discount', $id)->with('discounts','discountsStatus','commerce','branch')->first();

       return response()->json(['data'=> $data], 200);
    }    

    public function cancelUserHasDiscount($id){

      $data = UserHasDiscount::where('idusers_has_discount', $id)->first();

      $discount = Discount::find($data->discount_iddiscount);

      if ($discount->amountapproved != NULL) {
           
           $discount->amountavailable =  $discount->amountavailable + 1;

           $discount->save(); 
      }

      $data->delete();

      return response()->json(['data'=> $discount], 200);
    }
}
