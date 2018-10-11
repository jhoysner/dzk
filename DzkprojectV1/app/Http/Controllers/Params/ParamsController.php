<?php

namespace App\Http\Controllers\Params;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParamsCreateRequest;
use App\Http\Requests\ParamsUpdateRequest;

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
      $param = Params::where('idparams','=',$id);

      if(!$param) {
          return response()->json(['error' => 'No existe el parametro.'], 422);
      }

      $param->delete();

      return response()->json(['success'=>'Parametro eliminado correctamente'],200);
    }

    public function store(ParamsCreateRequest $request)
    {
      $input = $request->all();

      $input['idparams'] =str_random(36); //bin2hex(random_bytes(15));

      $param = Params::create($input);

      if(!$param) {
          return response()->json(['error' => 'Error al guardar.'], 422);
      }

      return response()->json(['success'=>'Parametro guardado correctamente'],201);
    }

    public function show($id)
    {
      $param = Params::where('idparams','=',$id)->get();

      if(!$param) {
          return response()->json(['error' => 'Error se encuentra el parametro.'], 422);
      }

      return response()->json(['success'=>true, 'param'=>$param],200);
      
    }

    public function update(ParamsUpdateRequest $request)
    {
      $id = $request->idparams;

      $param = Params::where('idparams','=',$id)->first();

      $input= $request->all();

      $update = $param->update($input);

      if(!$update) {
          return response()->json(['error' => 'Error al actualizar.'], 422);
      }

      return response()->json(['success'=>'Parametro actualizado correctamente'],200);

    }

}
