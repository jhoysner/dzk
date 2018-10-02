<?php

namespace App\Http\Controllers\Discount;

use App\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = Discount::all();

        return response()->json($discount);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = Discount::create([
                'iddiscount' => $request->iddiscount,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
                'startdate' => $request->startdate,
                'enddate' => $request->enddate,
                'outstanding' => $request->outstanding,
                'conditions' => $request->conditions,
                'restrictions' => $request->restrictions,
                'amountapproved' => $request->amountapproved,
                'amountavailable' => $request->amountavailable,
                'amountredeemed' => $request->amountredeemed,
                'normalprice' => $request->normalprice,
                'discountprice' => $request->discountprice,
                'discountpercentage' => $request->discountpercentage,
                'discountcategory_iddiscountcategory' => $request->discountcategory_iddiscountcategory,
        ]);

        if ( !$discount )
            return response()->json(['success' => false, 'mensage' => "El Descuento no se registro."], 422);

        return response()->json(['success' => true, 'discount'=> $discount]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discount = Discount::find($id);

        return response()->json($discount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);

        $discount->fill($request->all());

        if ($discount->save()) {

            return response()->json(['success' => true, 'discount'=> $discount]);
        }

        return response()->json(['success' => false, 'mensage' => "El Descuento no se actualizo."], 422);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::find($id);


        if ($discount->delete()) {
            
            return response()->json(['success' => true, 'discount'=> $discount]);
        }
        
        return response()->json(['success' => false, 'mensage' => "El Descuento no se Eliminado."], 422);

    }
}
