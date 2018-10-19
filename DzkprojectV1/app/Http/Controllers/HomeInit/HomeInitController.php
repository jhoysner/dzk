<?php

namespace App\Http\Controllers\HomeInit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Commerce;
use App\Branch;
use App\Discount;

class HomeInitController extends Controller
{
    public function allCommerce(Request $request)
    {

        /*$commerce = Commerce::with('countries')
        ->with('states')
          ->with('cities')
            ->with('ccategories')
              ->with('tags')
                ->paginate(2);*/

        //$commerce = Commerce::orderBy('idcommerce', 'DESC')->paginate(2);

        $commerce = Commerce::with('countries')
        ->with('states')
          ->with('cities')
            ->with('ccategories')
              ->with('tags');

              if($request->type = 'commerce') {
                if($request->category_commerce != null) {
                    $commerce->where('commercecategory_idcommercecategory', $request->category_commerce);
                }

                if($request->work != null) {
                    $commerce->where('name', 'LIKE', '%'.$request->work.'%');
                }

              }

        $page = $commerce->paginate(2);


        return response()->json([
            'paginate' => [
                'total'         =>  $page->total(),
                'current_page'  =>  $page->currentPage(),
                'per_page'      =>  $page->perPage(),
                'last_page'     =>  $page->lastPage(),
                'from'          =>  $page->firstItem(),
                'to'            =>  $page->lastPage()
            ],

            'commerce' => $page

        ]);

    }    
    public function allDiscount(Request $request)
    {
        // $discount = Discount::with('categories','tags')->with(['branchs' =>function ($query) {
     //                        $query->with('commerces');
                        // }])->paginate(2);

    	$discount = Discount::with('categories','tags')->with(['branchs' =>function ($query) {
                            $query->with('commerces');
                        }]);

            if($request->type = 'discount') {
                if($request->category_discount != null) {
                    $discount->where('discountcategory_iddiscountcategory', $request->category_discount);
                }

                if($request->work != null) {
                    $discount->where('title', 'LIKE', '%'.$request->work.'%');
                }

            }


        $page = $discount->paginate(2);


        return response()->json([
            'paginate' => [
                'total'         =>  $page->total(),
                'current_page'  =>  $page->currentPage(),
                'per_page'      =>  $page->perPage(),
                'last_page'     =>  $page->lastPage(),
                'from'          =>  $page->firstItem(),
                'to'            =>  $page->lastPage()
            ],

            'discount' => $page

        ]);
    }

    public function commerce_detail($id)
    {

        $commerce = Commerce::where('idcommerce', $id)
        ->with('countries')
            ->with('states')
              ->with('cities')
                ->with('ccategories')
                    ->with('tags')
                        ->with(['branchs' =>function ($query) {
                                $query->with('discounts');
                            }])->get();

        return response()->json(['data'=> $commerce], 200);

    }

    public function commerce_detail_random($id)
    {
        $commerce = Commerce::where('idcommerce', $id)
        ->with('countries')
            ->with('states')
              ->with('cities')
                ->with('ccategories')
                    ->with(['branchs' =>function ($query) {
                            $query->inRandomOrder()->take(2);
                            $query->inRandomOrder()->with('discounts')->take(2);
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
