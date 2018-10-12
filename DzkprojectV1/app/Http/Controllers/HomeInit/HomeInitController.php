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
              ->paginate(2);

        //$commerce = Commerce::orderBy('idcommerce', 'DESC')->paginate(2);

        return response()->json([
            'paginate' => [
                'total'         =>  $commerce->total(),
                'current_page'  =>  $commerce->currentPage(),
                'per_page'      =>  $commerce->perPage(),
                'last_page'     =>  $commerce->lastPage(),
                'from'          =>  $commerce->firstItem(),
                'to'            =>  $commerce->lastPage()
            ],

            'commerce' => $commerce

        ]);
    }

    public function commerce_detail($id)
    {
        $commerce = Commerce::where('idcommerce', $id)
        ->with('countries')
            ->with('states')
              ->with('cities')
                ->with('ccategories')
                    ->with(['branchs' =>function ($query) {
                            $query->with('discounts');
                        }])->get();

        return response()->json(['data'=> $commerce], 200);

    }
}
