<?php

namespace App\Http\Controllers\HomeInit;

use App\Branch;
use App\Commerce;
use App\Discount;
use App\Http\Controllers\Controller;
use App\UserHasDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;

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

                if($request->tags && count($request->tags) > 0) {

                    foreach ($request->tags as $value) {
              
                        $commerce->WhereHas('tags', function ($query) use ($value) {
                            $query->where('idtags',$value);
                        });
                    }
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
                if($request->tags && count($request->tags) > 0) {

                    foreach ($request->tags as $value) {
              
                        $discount->WhereHas('tags', function ($query) use ($value) {
                                            $query->where('idtags',$value);
                                        });
                    }
                }

                if($request->word != null) {
                    $discount->where('title', 'LIKE', '%'.$request->word.'%');
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
                    ->with(['branchs' =>function ($query) {
                            $query->with('commerces');
                        }])->get();

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

        $branchs = Branch::where('commerce_idcommerce', $id)
            ->with(['discounts' => function($q) {
                $q->with('categories','tags');
             }])->paginate(1);
                  
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

    public function  saveUserHasDiscount(Request $request)
    {

        $fields = $request->all();
        
        $fields['idusers_has_discount'] = str_random(36);

        $fields['charcode'] = str_random(4);

        $name = str_random(20).'.png';

        Storage::disk('public')->makeDirectory('qr');

        $file =  storage_path('app/public/qr/'.$name);

        $data = $fields['discount_iddiscount'].' | '.$fields['charcode'].' | '.$fields['validfrom'].' | '.$fields['validto'].' | '.$fields['commerce_idcommerce'].' | '.$fields['branch_idbranch'];

        QRCode::text($data)->setSize(8)->setOutfile($file)->png();

        // QRCode::url($request->root().'/qrcode/'.$fields['charcode'])->setSize(8)->setOutfile($file)->png();

        $fields['qrcode'] = $name;

        $user_has_discount = UserHasDiscount::create($fields);

        if ( !$user_has_discount )
            return response()->json(['error' => 'No se pudo guardar el registro'], 422);

        return response()->json(['data'=> $user_has_discount], 201);

    }
}
