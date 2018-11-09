<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Commerce;
use App\CommerceTags;
use App\Http\Requests\CommerceRequest;

use App\UserHasCommerce;

class CommercesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $commerce = Commerce::with('countries')
        ->with('states')
          ->with('cities')
            ->with('ccategories')
              ->get();

      return response()->json(['data'=> $commerce], 200);
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
    public function store(CommerceRequest $request)
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
        //$path = public_path().'/images/commerce/'.$filename;
        //file_put_contents($path, $decoded);
        Storage::disk('commerce')->put($filename, $decoded);
      }else {
        $filename = null;
      }

      $data = [
        'idcommerce'  => str_random(36),
        'name'        => $request->name,
        'phone1'      => $request->phone1,
        'phone2'      => $request->phone2,
        'email'       => $request->email,
        'image'       => $filename,
        'web'         => $request->web,
        'country_idcountry'   => $request->country_idcountry,
        'state_idstate'       => $request->state_idstate,
        'city_idcity'         => $request->city_idcity,
        'commercecategory_idcommercecategory'  => $request->commercecategory_idcommercecategory,
      ];

      $commerce = Commerce::create($data);

      UserHasCommerce::create([
        'idusers_has_commerce'  => str_random(36),
        'users_id'  =>  $request->idUser,
        'commerce_idcommerce' => $commerce->idcommerce
      ]);

      if(count($request->tags) > 0) {
        foreach ($request->tags as $value) { 

                $idcommerce_has_tags = str_random(36);

                CommerceTags::create([
                   'idcommerce_has_tags' => $idcommerce_has_tags,
                   'commerce_idcommerce' => $commerce->idcommerce,
                   'tags_idtags'=> $value['code']
                ]);
                
            }
      }

      if(!$commerce){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($commerce,  201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $commerce = Commerce::where('idcommerce', $id)
        ->with('countries')
          ->with('states')
            ->with('cities')
              ->with('ccategories')
                ->get();

        return response()->json($commerce,  201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $commerce = Commerce::where('idcommerce', $id)
        ->with('countries')
          ->with('states')
            ->with('cities')
              ->with('ccategories')
                ->get();

        return response()->json($commerce,  201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommerceRequest $request, $id)
    {
      $commerce = Commerce::find($id);

      if($commerce->image != $request->image) {
        Storage::disk('commerce')->delete($commerce->image);

        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg')) {
          $ext = 'jpg';
        } else {
          $ext = 'png';
        }

        $filename = str_random().'.'.$ext;
        //$path = public_path().'/images/commerce/'.$filename;
        //file_put_contents($path, $decoded);
        Storage::disk('commerce')->put($filename, $decoded);
      } else {
        $filename = $commerce->image;
      }

      $data = [
        'name'        => $request->name,
        'phone1'      => $request->phone1,
        'phone2'      => $request->phone2,
        'email'       => $request->email,
        'image'       => $filename,
        'web'         => $request->web,
        'country_idcountry'   => $request->country_idcountry,
        'state_idstate'       => $request->state_idstate,
        'city_idcity'         => $request->city_idcity,
        'commercecategory_idcommercecategory'  => $request->commercecategory_idcommercecategory,
      ];

      $update = $commerce->update($data);

      //elimina tags
      $commercetags = CommerceTags::where('commerce_idcommerce',$commerce->idcommerce)->get();
      foreach ($commercetags as $temp) {
          $temp->delete();
      }

      //si existe tags los agrega
      if(count($request->tags) > 0) {
          foreach ($request->tags as $value) { 
              $idcommerce_has_tags = str_random(36);
              CommerceTags::create([
                  'idcommerce_has_tags' => $idcommerce_has_tags,
                  'commerce_idcommerce' => $commerce->idcommerce,
                  'tags_idtags'=> $value['code']
              ]);
          }
      }

      if(!$commerce){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($commerce,  201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commerce = Commerce::destroy($id);

        if(!$commerce){
            return response()->json(['error' => 'No se pudo guardar el registro'], 422);
        }

        return response()->json(['msg' => 'Comercio eliminado satisfactoriamente.'], 201);
    }

    public function getTagsCommerce($id)
    {
        $commerce = Commerce::find($id);

        $commercetags = $commerce->tags;

        return response()->json(['data'=> $commercetags], 200);
    }

}
