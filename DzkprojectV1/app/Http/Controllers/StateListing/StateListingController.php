<?php

namespace App\Http\Controllers\StateListing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StateListing;

class StateListingController extends Controller
{
	public function index()
	{
		$state = StateListing::select('idstatelisting','name')->get();

		return response()->json(['success'=>true, 'data'=>$state], 200);  
	}    
}
