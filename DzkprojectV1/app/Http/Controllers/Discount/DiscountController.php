<?php

namespace App\Http\Controllers\Discount;

use App\Discount;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();

        return response()->json(['data'=> $discounts], 200);
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
    public function store(DiscountRequest $request)
    {   
        if($request->image) {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if(str_contains($exploded[0], 'jpeg')) {
              $ext = 'jpg';
            } else {
              $ext = 'png';
            }
            $filename = str_random().'.'.$ext;
            Storage::disk('discount')->put($filename, $decoded);

        }

        $fields = $request->all();

        $fields['iddiscount'] = str_random(36);

        $fields['image'] = $filename;

        $discount = Discount::create($fields); 

        if ( !$discount )
            return response()->json(['error' => 'No se pudo guardar el registro'], 422);

        return response()->json(['data'=> $discount], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discount = Discount::findOrFail($id);

        return response()->json(['data'=> $discount], 200);
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
    public function update(DiscountRequest $request, $id)
    {
        $discount = Discount::find($id);

        $discount->fill($request->all());

        if ($discount->save()) {

            return response()->json(['data'=> $discount], 200);
        }

        return response()->json(['error' => 'No se pudo actualizar el registro'], 422);

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
            
            return response()->json(['data'=> $discount], 200);
        }
        
        return response()->json(['error' => 'No se pudo eliminar el registro'], 422);

    }
}
