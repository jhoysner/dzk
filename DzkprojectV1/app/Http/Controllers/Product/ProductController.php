<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductType;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Lang;

class ProductController extends Controller
{
    public function index()
    {
    	$productos = Product::with('commerces')
    					->with('type')
    						->get();

    	return response()->json(['success'=>true, 'data'=>$productos], 200);
    }

    
    public function store(ProductCreateRequest $request)
    {

        if($request->hasFile('image')) {
            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $fullname = str_random().'.'.$extension;
            Storage::disk('product')->put($fullname, \File::get($image)); 
        } 

        $product = new Product();
        $product->idproduct = str_random(36);
        $product->name = $request->name;
        if($request->reference)
            $product->reference = $request->reference;
        $product->usestock = $request->usestock;
        $product->producttype_idproducttype = $request->producttype_idproducttype;
        $product->commerce_idcommerce = $request->commerce_idcommerce;
        if($request->hasFile('image'))
            $product->image = "images/product/".$fullname;
        $product->save();

    	if(!$product->save()) {
          return response()->json(['error' => 'Error al guardar.'], 422);
      	}

      	return response()->json(['success'=>\Lang::get('messages.product_save')],201);
    }


    public function show($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json(['error' => 'No encontrado'], 422);
        }

        return response()->json(['success'=>true, 'data'=>$product], 200);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
	    
        $product = Product::find($id);

        if(!$product){
            return response()->json(['error' => 'No encontrado'], 422);
        }

    	if($request->image != $product->image) {
            Storage::disk('product')->delete($product->image);

            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);

            $type = explode(';', $exploded[0]);
            $ext = explode('/',$type[0]);
            $fullname = str_random().'.'.$ext[1];
            Storage::disk('product')->put($fullname, $decoded); 
        } 

        $input= $request->all();

        if(isset($fullname)) {
            $input['image'] = 'images/product/'.$fullname;
        }


     	$update = $product->update($input);

      	if(!$update) {
        	return response()->json(['error' => 'Error al actualizar.'], 422);
      	}

    	return response()->json(['success'=>\Lang::get('messages.product_update')],200);

    }

    public function destroy($id)
    {
        $product = Product::destroy($id);

        if(!$product){
            return response()->json(['error' => 'Error al eliminar'], 422);
        }

        return response()->json(['success' => \Lang::get('messages.product_delete')], 201);

    }

    public function getTiposProductos()
    {
    	$tipos = ProductType::select('idproducttype','name')
    							->orderBy('name','ASC')
    								->get();
    
    	return response()->json(['success'=>true, 'data'=>$tipos], 200);
    }

}
