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
    public function allDiscount()
    {
    	$discount = Discount::with('branchs')
              ->paginate(2);

        //$discount = discount::orderBy('iddiscount', 'DESC')->paginate(2);

        return response()->json([
            'paginate' => [
                'total'         =>  $discount->total(),
                'current_page'  =>  $discount->currentPage(),
                'per_page'      =>  $discount->perPage(),
                'last_page'     =>  $discount->lastPage(),
                'from'          =>  $discount->firstItem(),
                'to'            =>  $discount->lastPage()
            ],

            'discount' => $discount

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

    public function discount_detail($id)
    {
        $discount = Discount::where('iddiscount', $id)
                    ->with('branchs')->get();

        return response()->json(['data'=> $discount], 200);

    }

    public function commerce_detail_branchs($id)
    {
        $branch = Branch::where('commerce_idcommerce', $id)->paginate(2);

        return response()->json([
            'paginate' => [
                'total'         =>  $branch->total(),
                'current_page'  =>  $branch->currentPage(),
                'per_page'      =>  $branch->perPage(),
                'last_page'     =>  $branch->lastPage(),
                'from'          =>  $branch->firstItem(),
                'to'            =>  $branch->lastPage()
            ],

            'branch' => $branch

        ]);
    }    
    public function commerce_detail_discount($id)
    {

        $branchs = Branch::where('commerce_idcommerce', $id)->with('discounts')->paginate(1);
                  

        return response()->json([
            'paginate' => [
                'total'         =>  $branchs->total(),
                'current_page'  =>  $branchs->currentPage(),
                'per_page'      =>  $branchs->perPage(),
                'last_page'     =>  $branchs->lastPage(),
                'from'          =>  $branchs->firstItem(),
                'to'            =>  $branchs->lastPage()
            ],

            'branchs' => $branchs

        ],200);
    }
}
