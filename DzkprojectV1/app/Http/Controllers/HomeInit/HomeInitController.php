<?php

namespace App\Http\Controllers\HomeInit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Commerce;
use App\Branch;
use App\Discount;

class HomeInitController extends Controller
{
    public function allCommerce()
    {
    	$commerce = Commerce::with('countries')
        ->with('states')
          ->with('cities')
            ->with('ccategories')
              ->get();

        return response()->json(['data'=> $commerce], 200);
    }

    public function commerce_detail($id)
    {
    	$commerce = Commerce::where('idcommerce', $id)
    	->with('countries')
	        ->with('states')
	          ->with('cities')
	            ->with('ccategories')
	              ->get();

        return response()->json(['data'=> $commerce], 200);
    }
}
