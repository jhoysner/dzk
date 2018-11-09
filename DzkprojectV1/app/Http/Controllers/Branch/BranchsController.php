<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\BranchRequest;
use App\Branch;
use App\User;
use Helper;
use DB;

class BranchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $branch = Branch::with('countries')
        ->with('states')
          ->with('cities')
            ->with('commerces')
              ->get();

      return response()->json(['data'=> $branch], 200);
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
    public function store(BranchRequest $request)
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
        //$path = public_path().'/images/branch/'.$filename;
        //file_put_contents($path, $decoded);
        Storage::disk('branch')->put($filename, $decoded);
      } else {
        $filename = null;
      }

      $data = [
        'idbranch'    => str_random(36),
        'name'        => $request->name,
        'address'     => $request->address,
        'schedule'    => $request->schedule,
        'phone1'      => $request->phone1,
        'phone2'      => $request->phone2,
        'image'       => $filename,
        'latitude'    => $request->latitude,
        'longitude'   => $request->longitude,
        'commerce_idcommerce'  => $request->commerce_idcommerce,
        'country_idcountry'   => $request->country_idcountry,
        'state_idstate'       => $request->state_idstate,
        'city_idcity'         => $request->city_idcity,
      ];

      $branch = Branch::create($data);

      if(!$branch){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($branch,  201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $branch = Branch::where('idbranch', $id)
        ->with('countries')
          ->with('states')
            ->with('cities')
              ->with('commerces')
                ->with('discounts')
                 ->get();

      return response()->json(['data'=> $branch], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $branch = Branch::where('idbranch', $id)
        ->with('countries')
          ->with('states')
            ->with('cities')
              ->with('commerces')
                ->get();

      return response()->json(['data'=> $branch], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
      $branch = Branch::find($id);

      if($branch->image != $request->image) {
        Storage::disk('branch')->delete($branch->image);

        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg')) {
          $ext = 'jpg';
        } else {
          $ext = 'png';
        }

        $filename = str_random().'.'.$ext;
        //$path = public_path().'/images/branch/'.$filename;
        //file_put_contents($path, $decoded);
        Storage::disk('branch')->put($filename, $decoded);
      } else {
        $filename = $branch->image;
      }

      $data = [
        'name'        => $request->name,
        'address'     => $request->address,
        'schedule'    => $request->schedule,
        'phone1'      => $request->phone1,
        'phone2'      => $request->phone2,
        'image'       => $filename,
        'latitude'    => $request->latitude,
        'longitude'   => $request->longitude,
        'commerce_idcommerce'  => $request->commerce_idcommerce,
        'country_idcountry'   => $request->country_idcountry,
        'state_idstate'       => $request->state_idstate,
        'city_idcity'         => $request->city_idcity,
      ];

      $update = $branch->update($data);

      if(!$branch){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($branch,  201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $branch = Branch::destroy($id);

      if(!$branch){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json(['msg' => 'Sucursal eliminada satisfactoriamente.'], 201);
    }

    protected function getLocalizationUser()
    {
      $id_user = Auth::id();

      $user= User::find($id_user); 

      $localization = [];

      if(isset($user)) {
        $localization['latitude']  = $user->latitude;
        $localization['longitude'] = $user->longitude;        
      } else {
        $coord = Helper::getCoordenateDefault(); //$this->getCoordenateDefault();
        $coord = json_decode($coord['val'], true);

        $localization['latitude']  = $coord['latitud'];
        $localization['longitude'] = $coord['longitud'];                
      }
      
      return $localization;
    }

    public function getBranchs()
    {
      //Obtiene la latitud y logitud del cliente 
      $local_user = $this->getLocalizationUser();
                    
      //Obtiene los rangos de busqueda de distancia
      $range = Helper::getSearchRange();

      if(is_null($range)){
        $val_range = [0,500];
      } else {
        $val_range = explode(',', trim($range->val,'{}'));
      }

      $ri = 0;
      $num_range = count($val_range);
      //Recorre los rangos hasta encontrar Branchs
      while($ri < $num_range) {
        $rango1 = $val_range[$ri];
        if(isset($val_range[$ri+1])) {
          $rango2 = $val_range[$ri+1];
        } else {
          $rango2 = null;
        }

        $branchs = DB::select('call sp_getbranch_from_location(?,?,?,?)', array($local_user['latitude'],$local_user['longitude'],$rango1,$rango2));

        if(count($branchs) > 0) {
          break;
        }

        $ri++;
      }

      $branch_detail = array();
      foreach($branchs as $b) {
        $branch = Branch::select('idbranch','name','latitude','longitude')
                    ->where('idbranch',$b->idbranch)
                      ->first();
        $branch_detail[] = $branch;
       
      }
      return response()->json(['data'=> $branch_detail], 200);
    }
}
