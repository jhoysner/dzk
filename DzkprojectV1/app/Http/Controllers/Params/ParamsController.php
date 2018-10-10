<?php

namespace App\Http\Controllers\Params;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Params;

class ParamsController extends Controller
{
    public function getCommerceSize()
    {
    	$param = Params::where('key', 'commerce_img_upload_size')->get();

    	if(!$param){
          return response()->json(['error' => 'No se encontraron valores por defecto.'], 422);
      	}

      	return response()->json($param,  201);
    }

    public function getCommercetype()
    {
    	$param = Params::where('key', 'commerce_img_upload_type')->get();

    	if(!$param){
          return response()->json(['error' => 'No se encontraron valores por defecto.'], 422);
      	}

      	return response()->json($param,  201);
    }

    public function getBranchSize()
    {
    	$param = Params::where('key', 'branch_img_upload_size')->get();

    	if(!$param){
          return response()->json(['error' => 'No se encontraron valores por defecto.'], 422);
      	}

      	return response()->json($param,  201);
    }

    public function getBranchtype()
    {
    	$param = Params::where('key', 'branch_img_upload_type')->get();

    	if(!$param){
          return response()->json(['error' => 'No se encontraron valores por defecto.'], 422);
      	}

      	return response()->json($param,  201);
    }

    public function index()
    {
      $params = Params::all();

      return response()->json(['success'=>'', 'params'=>$params],200);
    
    }

    public function destroy($id)
    {
      $param = Params::find($id);

      if(!$param) {
          return response()->json(['error' => 'No existe el parametro.'], 422);
      }

      $param->delete();

      return response()->json(['success'=>'Parametro eliminado correctamente'],200);

    }
}
