<?php

namespace App\Http\Controllers\Tags;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Tags;

class TagsController extends Controller
{
    public function index()
    {
    	$tags = Tags::all();

    	return response()->json(['success'=>true, 'tags'=>$tags], 200);
    }

    public function store(TagsRequest $request)
    {
    	$input = $request->all();

    	if($request->code) {
    		$input['idtags'] = $request->code;
    	} else {
	    	$input['idtags'] = str_random(36);
    	}

    	$tag = Tags::create($input);

    	if(!$tag) {
          return response()->json(['error' => 'Error al guardar.'], 422);
      	}

      	return response()->json(['success'=>'Tag guardado correctamente'],201);
    }

    public function show($id)
    {
    	$tag = Tags::where('idtags','=',$id)->get();
    
    	return response()->json(['success'=>true, 'tag'=>$tag],200);
    }

    public function update(TagsRequest $request)
    {
	    $id = $request->idtags;

    	$tag = Tags::where('idtags','=',$id)->first();

    	$input= $request->all();

     	$update = $tag->update($input);

      	if(!$update) {
        	return response()->json(['error' => 'Error al actualizar.'], 422);
      	}

    	return response()->json(['success'=>'Tag actualizado correctamente'],200);

    }

    public function search($search)
    {
    	$tags = Tags::where('name', 'like', '%'.$search.'%')->get();

    	return response()->json(['tags'=>$tags],200);
    }
}
