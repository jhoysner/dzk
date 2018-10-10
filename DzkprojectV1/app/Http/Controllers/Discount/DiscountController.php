<?php

namespace App\Http\Controllers\Discount;

use App\Branch;
use App\BranchDiscount;
use App\Discount;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
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
        $fields = $request->all();

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

            $fields['image'] = $filename;
        }


        $fields['iddiscount'] = str_random(36);

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
        $discount= Discount::find($id);
        

        $exploded = explode(',', $request->image);

        if ($request->image && count($exploded) > 1) {

            if (Storage::disk('discount')->exists($discount->image)) {
                //se borra la imagen anterior    
                Storage::disk('discount')->delete($discount->image);
            }
            //nueva imagen
            $decoded = base64_decode($exploded[1]);
            if(str_contains($exploded[0], 'jpeg')) {
              $ext = 'jpg';
            } else {
              $ext = 'png';
            }
            $filename = str_random().'.'.$ext;
            Storage::disk('discount')->put($filename, $decoded);
            
            $imageName = $filename;
        } 
        else{
            $imageName= $discount->image; 
        }
        
        
        $discount->fill($request->except(['image']));

        $discount->image = $imageName;

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

        if (Storage::disk('discount')->exists($discount->image)) {

            Storage::disk('discount')->delete($discount->image);
        }
                
        if ($discount->delete()) {
            
            return response()->json(['data'=> $discount], 200);
        }
        
        return response()->json(['error' => 'No se pudo eliminar el registro'], 422);

    }   

    public function branchDiscount(Request $request)
    {
        // dd($request->all());

        if (count($request->sucursales) > 0) {
            foreach ($request->sucursales as $value) { 

                $idbranch_has_discount = str_random(36);

                // return response()->json(['data'=> $value], 201);

                BranchDiscount::create([
                   'idbranch_has_discount' => $idbranch_has_discount,
                   'discount_iddiscount' => $request->discount_iddiscount,
                   'branch_idbranch'=> $value['branch_idbranch'],
                   'amountapproved'=> $value['amountapproved'],
                   'discounthours'=> $value['discounthours'],
                ]);
                
            }
        }
        else{

           $branchs =  Branch::all();

           foreach ($branchs as $value) {
                $idbranch_has_discount = str_random(36);
                
                BranchDiscount::create([
                   'idbranch_has_discount' => $idbranch_has_discount,
                   'discount_iddiscount' => $request->discount_iddiscount,
                   'branch_idbranch'=> $value->idbranch,
                   'amountapproved'=> $request->amountapproved,
                   'discounthours'=> $request->discounthours,
                ]);
           }
        }

        return response()->json(['success'=> true], 201);

    }    

    public function getBranchDiscount($id)
    {

        $discount = Discount::find($id);

        $relacion = $discount->branchs;

        return response()->json(['data'=> $relacion], 201);
    }    

    public function editBranchDiscount($discount,$id)
    {
        $discount = Discount::find($discount);

        $data  = $discount->branchs()->wherePivot('idbranch_has_discount', $id)->first();

        return response()->json(['data'=> $data], 201);
    }

    public function updateBranchDiscount(Request $request, $discount,$id){

        $discount = Discount::find($discount);

        $data  = $discount->branchs()->wherePivot('idbranch_has_discount', $id)->first();

        $data->pivot->amountapproved = $request->amountapproved;
        $data->pivot->discounthours = $request->discounthours;
        $data->pivot->save();

        return response()->json(['data'=> $data], 201);
    }


    public function branchDiscountDelete($discount,$id){

        $discount = Discount::find($discount);

        $data  = $discount->branchs()->wherePivot('idbranch_has_discount', $id)->first();

        $data->pivot->delete();
        
        return response()->json(['data'=> $data], 201);

    }
}
