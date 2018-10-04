<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Commerce;
use App\Http\Requests\CommerceRequest;

class CommercesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $path = public_path().'/images/commerce/'.$filename;
        file_put_contents($path, $decoded);
      }

      /*$data = [
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

      if(!$commerce){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($commerce,  201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
