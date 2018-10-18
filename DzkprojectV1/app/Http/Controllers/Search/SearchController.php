<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Branch;
use App\Discount;
use App\Commerce;
use DB;


class SearchController extends Controller
{
    
	public function getSearch(Request $request)
    {
      
      $locUser = $this->getLocalization(1);

	  $branchs = DB::select('call sp_branchs_user('.$locUser['latitude'].','.$locUser['longitude'].')');

	  foreach ($branchs as $value) {
	  	$commerces = $commerce = Commerce::where('idcommerce', $id)
						        ->with('countries')
						            ->with('states')
						              ->with('cities')
						                ->with('ccategories')
						                    ->with(['branchs' =>function ($query) {
						                            $query->with('discounts');
						                        }])->get();

	  	return ($commerces);
	  }

	dd($branchs);



	  switch ($request->type) {
	    case 'commerce':
	      

	      $commerces = Commerce::with('branchs')->get();
	      
	      foreach ($commerces as $value) {
	        foreach ($value->branchs as $temp) {
	          $temp['distance'] = $this->getDistancia($userLat,$userLng,$temp->lalitude,$temp->longitude);
	        }

	        //$value->branchs()->sortByDesc('')

	      }

	      $ordenados = $commerces->branchs()->orderBy('distance', 'DESC');
	      return($ordenados);
	      return($commerces);


	      
	      $query = Commerce::select()->orderBy('commerce.name', 'ASC'); 

	      if($request->idtags) {
	        $query = $query->join('commerce_has_tags','commerce.idcommerce', '=', 'commerce_has_tags.commerce_idcommerce');
	        foreach ($request->idtags as $key => $value) {
	            $query = $query->orWhere(function($q) use ($value){
	                $q->where('commerce_has_tags.tags_idtags','=',$value);
	            });
	        }
	      }

	      if($request->idcommercecategory) {
	        $query = $query->where('commercecategory_idcommercecategory','=', $request->idcommercecategory);
	      }

	      if($request->words) {
	        $query= $query->where('commerce.name', 'like', '%'.$request->words.'%');
	      }
	      
	      if($request->offset) {
	        $query = $query->offset($request->offset);
	      }

	      if($request->limit) {
	        $query = $this->getLimit($query, $request->limit);
	      } else {
	        $query = $this->getLimit($query);
	      }

	      return response()->json(['success'=>true, 'data'=>$query]);
	      break;
	    
	    case 'discount':
	      
	    $discounts = Discount::with('branchs')->get();

	   /* foreach ($discounts as $key => $value) {
	      $branch = $value->branchs;
	    }*/

	  return($discounts);

	      /*if($request->idtags) {
	        $query = $query->join('discount_has_tags','commerce.idcommerce', '=', 'commerce_has_tags.commerce_idcommerce');
	        foreach ($request->idtags as $key => $value) {
	            $query = $query->orWhere(function($q) use ($value){
	                $q->where('commerce_has_tags.tags_idtags','=',$value);
	            });
	        }
	      }*/

	      if($request->iddiscountcategory) {
	        $query = $query->where('commercecategory_idcommercecategory','=', $request->idcommercecategory);
	      }

	      if($request->words) {
	        $query= $query->where('discount.title', 'like', '%'.$request->words.'%');
	      }
	      
	      if($request->offset) {
	        $query = $query->offset($request->offset);
	      }

	      if($request->limit) {
	        $query = $this->getLimit($query, $request->limit);
	      } else {
	        $query = $this->getLimit($query);
	      }

	      return response()->json(['success'=>true, 'data'=>$query]);
	      break;
	    
	    default:
	      return response()->json(['error' => 'Se requiere el tipo de busqueda a realizar'], 422);
	      break;
	  }

    }

    // Limita el query
    protected function getLimit ($query, $limit = 10) {
        
        $data = $query->limit($limit)->get();

        return $data;
    }

    protected function getLocalization($id)
    {
    	$idUser ="851e91410915be4dbd49";

  		$user= User::find($idUser); 

	  	$localization = [];

	  	$localization['latitude'] = $user->latitude;
	  	$localization['longitude'] = $user->longitude;
	  	
	  	return $localization;
    }
}
