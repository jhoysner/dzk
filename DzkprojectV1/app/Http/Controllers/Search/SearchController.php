<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Params;
use App\User;
use App\Branch;
use DB;


class SearchController extends Controller
{
    protected function getSearchRange()
    {
    	$param = Params::where('key','distance_search_range')->first();
    	return $param;
    }

    protected function getAlphaNumeric($cadena)
    {
    	$cadenaLimpia = preg_replace('([^A-Za-z0-9 ])', '', $cadena);	     					
      	return $cadenaLimpia;
    }

    protected function getQuitElement($array_word)
    {
    	$elementos = array('el', 'los', 'la', 'las', 'un', 'una', 'unos', 'unas', 'de', 'del', 'en');

    	$result = array_diff($array_word, $elementos);
    	return $result;
    }

    protected function getWord($cadena)
    {
    	$word = "";
		//Limpiar caracteres solo alfanumericos
		$word = $this->getAlphaNumeric($cadena);
		//conversion a minusculas
		$word = strtolower($word);
		//reemplazo b v por comodin *
		
		//split quitar espacio 
		$word = preg_split("/[\s,]+/", $word);

		//retirar los articulos (el, los, la, las, un, una, unos, unas, de, del, en)
		$word = $this->getQuitElement($word);

		return $word;
    }


	public function getSearch(Request $request)
	{
		$validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

		$limit = 10;
		$offset = 0;

		//Obtiene la latitud y logitud del cliente 
      	$local_user = $this->getLocalizationUser();
      	      	
		//Obtiene los rangos de busqueda de distancia
		$range = $this->getSearchRange();
		
		if(is_null($range)){
			$val_range = [0,500];
		} else {
			$val_range = explode(',', trim($range->val,'{}'));
		}
		
		//Recorre los rangos hasta encontrar Branchs
		$ri = 0;
		while($ri < count($val_range)) {
			$rango1 = $val_range[$ri];
			if(isset($val_range[$ri+1])) {
				$rango2 = $val_range[$ri+1];
			} else {
				$rango2 = null;
			}

			$branchs = DB::select('call sp_branchs_user(?,?,?,?,?,?)', array($local_user['latitude'],$local_user['longitude'],$rango1,$rango2,$limit,$offset));

			if(count($branchs) > 0) {
				break;
			}

			$ri++;
		}

      	$branch = array();
      	foreach ($branchs as $key => $value) {
      		$branch[] = $value->idbranch; 
      	}

		switch ($request->type) {
	    	case 'commerce':      	
				$query = Branch::with(['commerces' => function($q) use($request) {
								//Valida que exista una categoria
		    					if($request->category_commerce) {			  					
									$category_commerce = $request->category_commerce;
									$q->where('commercecategory_idcommercecategory',$category_commerce);
					  			}
					  			//Valida que exista una palabra
					  			if($request->word) {			  					
									//realiza opciones de limpiado, conversion minuscula, etc
									$word = $this->getWord($request->word);
									//Incluir elemento del array obtenido
									foreach ($word as $value) {
										if($value === reset($word)){
											$q->where('name','like','%'.$value.'%');
										} else {
											$q->orWhere('name','like','%'.$value.'%');
										}
									}
							  	}
							  	$q->with(['tags' => function($p) use($request) {
							  		//Valida que exista Tags
							  		if($request->tags) {
							  			$tags = $request->tags;
							  			foreach ($tags as $value) {
							  				if($value === reset($tags)){
												$p->where('idtags',$value);
											} else {
												$p->orWhere('idtags',$value);
											}		
							  			}
							  		}
							  	}]);	
							  	$q->with('ccategories');

							}]);

	    		$query = $query->paginate($limit);
	    		//$query = $query->get();
	 			
	 			$paginate = $this->getPaginate($query);

				$resultado = [];
				foreach ($query as $value) {
		      		$resultado[$value->idbranch] =$value;	
		      	}

				//Ordena el resultado obtenido por distancia
		    	foreach ($branchs as $key => $value) {
		    		if($resultado[$value->idbranch]['commerces'] == ""){
		    			unset($branchs[$key]);
		    		} else {
		    			$value->commerce = $resultado[$value->idbranch]['commerces'];
		    		}
		    		
		    	}

		    	$data=[];
		    	$data['commerces'] = $branchs;
				
				return response()->json([
										'success' => true, 
										'data'     => $data,
										'paginate' => $paginate
										], 200);
				break;

	    	case 'discount':
	    		$query = Branch::select('idbranch')
	    					->with(['discounts'=> function($q) use($request) {
		    					//Valida que exista una categoria
		    					if($request->category_discount) {			  					
									$category_discount = $request->category_discount;
									$q->where('discountcategory_iddiscountcategory',$category_discount);
					  			}
					  			//Valida que exista una palabra
					  			if($request->word) {			  					
									//realiza opciones de limpiado, conversion minuscula, etc
									$word = $this->getWord($request->word);
									//Incluir elemento del array obtenido
									foreach ($word as $value) {
										if($value === reset($word)){
											$q->where('title','like','%'.$value.'%');
										} else {
											$q->orWhere('title','like','%'.$value.'%');
										}
									}
							  	}
							  	$q->with(['tags' => function($p) use($request) {
							  		//Valida que exista Tags
							  		if($request->tags) {
							  			$tags = $request->tags;
							  			foreach ($tags as $value) {
							  				if($value === reset($tags)){
												$p->where('idtags',$value);
											} else {
												$p->orWhere('idtags',$value);
											}		
							  			}
							  		}
							  	}]);	
							  	$q->with('categories');	
		    				}])
	    					->whereIn('idbranch',$branch);

	    		$query = $query->paginate($limit);
	    		//$query = $query->get();
	 			
	 			$paginate = $this->getPaginate($query);

	    		$resultado = [];
				foreach ($query as $value) {
		      		$resultado[$value->idbranch] =$value;	
		      	}

		      	//Ordena el resultado obtenido por distancia ASC
		    	foreach ($branchs as $key => $value) {
		    		if($resultado[$value->idbranch]['discounts']->count() == 0){
		    			unset($branchs[$key]);
		    		} else {
		    			$value->discount = $resultado[$value->idbranch]['discounts'];
		    		}
		    		
		    	}

		    	$data=[];
		    	$data['discounts'] = $branchs;

				return response()->json([
										'success'  => true, 
										'data' 	   => $data,
										'paginate' => $paginate
										], 200);
	    		break;
	    
	    	default:
	      		return response()->json(['error' => 'Se requiere el tipo de busqueda a realizar'], 422);
	      		break;
	    }

	}


    protected function getLocalizationUser()
    {
    	$id_user = "851e91410915be4dbd49";

  		$user= User::find($id_user); 

	  	$localization = [];

	  	if(isset($user)) {
		  	$localization['latitude']  = $user->latitude;
		  	$localization['longitude'] = $user->longitude;	  		
	  	} else {
		  	$localization['latitude']  = 4.710988599999999;
		  	$localization['longitude'] = -74.072092;	  			  		
	  	}
	  	
	  	return $localization;
    }

    protected function getPaginate($query)
    {
    	$data = [
		    'total'         =>  $query->total(),
	        'current_page'  =>  $query->currentPage(),
	        'per_page'      =>  $query->perPage(),
	        'last_page'     =>  $query->lastPage(),
	        'from'          =>  $query->firstItem(),
	        'to'            =>  $query->lastPage(),
    	];
    	return $data;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type'  => 'required|string',
            'tags' 	=> 'array',
            'word'  => 'string',
        ]);
    }

	
}
