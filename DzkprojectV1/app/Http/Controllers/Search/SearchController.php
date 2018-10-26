<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Params;
use App\User;
use App\Branch;
use App\Discount;
use App\Commerce;
use DB;


class SearchController extends Controller
{
    protected function getSearchRange()
    {
    	$param = Params::where('key','search_distance_ranges')->first();
    	return $param;
    }

    protected function getCoordenateDefault()
    {
		$param = Params::where('key','coordenates_default')->first();
    	return $param;	
    }

    protected function getLimit()
    {
		$param = Params::where('key','search_limit_row')->first();
    	return $param;	
    }

    protected function getPerPage()
    {
		$param = Params::where('key','search_paginate')->first();
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

    protected function getComodin($cadena)
    {
    	$string_reemp = array('v','b');

    	foreach ($string_reemp as $value) {
    		$cadena = str_replace($value, '_', $cadena);
    	}
    	
    	return $cadena;
    }

    protected function getWord($cadena)
    {
    	$word = "";
		//Limpiar caracteres solo alfanumericos
		$word = $this->getAlphaNumeric($cadena);
		//conversion a minusculas
		$word = strtolower($word);
		//reemplazo b v por comodin *
		$word = $this->getComodin($word);
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

        //Limite de sucursales a devolver
		$limit = $this->getLimit();
		$limit = intval($limit->val);

		if(!$request->offset) {
			$offset = 0;
		} else {
			$offset = $request->offset;
		}
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

			$branchs = DB::select('call sp_getbranch_from_location(?,?,?,?,?,?)', array($local_user['latitude'],$local_user['longitude'],$rango1,$rango2,$limit,$offset));

			if(count($branchs) > 0) {
				break;
			}

			$ri++;
		}

      	$branch = array();
      	$branchsOrder = array();
      	foreach ($branchs as $key => $value) {
      		$branch[] = $value->idbranch; 
      		$branchsOrder[$key] = $value->idbranch;
      	}


		switch ($request->type) {
	    	case 'commerce':      	

 				$query = Commerce::with('ccategories','tags')
 						->with('branchs'); 						

 				$query->whereHas('branchs', function($q) use($branch) {
                	$q->whereIn('idbranch',$branch);
                });

				if($request->category_commerce) {
					$category_commerce = $request->category_commerce;
                    $query->where('commercecategory_idcommercecategory', $category_commerce);
                }

                if($request->word) {			  					
					//realiza opciones de limpiado, conversion minuscula, etc
					$word = $this->getWord($request->word);
					//Incluir elemento del array obtenido
					foreach ($word as $value) {
						if($value === reset($word)){
							$query->where('name','like','%'.$value.'%');
						} else {
							$query->orWhere('name','like','%'.$value.'%');
						}
					}
			  	}

                if($request->tags && count($request->tags) > 0) {
                	$tags = $request->tags;
                    foreach ($tags as $value) {
                       $query->WhereHas('tags', function ($query) use ($value) {
                                $query->where('idtags',$value);
                        });
                    }
                }

	    		$query = $query->paginate($limit);
	    		
	    		$paginate = $this->getPaginate($query);

				$resultado = [];
				$val_ant = 0;


				foreach ($query as $key => $value) {
					
					foreach($value->branchs as $temp){
						$r = array_search($temp->idbranch, $branchsOrder);
						if($r) {
							if($val_ant>$r || $val_ant == $r) {
								unset($resultado[$val_ant]);
								$resultado[$r] = $value;
								$val_ant = $r;
							} else {
								$resultado[$r] = $value;
								$val_ant = $r;
							}							
						}
						//$resultado[$r] = $value;
					}
		      		//$resultado[$key] =$value;	
		      	}



/*		      	$commerces= [];
		      	$k=1;
				//Ordena el resultado obtenido por distancia
		    	foreach ($branchs as $key => $value) {
		    		if($resultado[$value->idbranch]['commerces'] == ""){
		    			unset($branchs[$key]);
		    		} else {
		    			if($request->tags) {
		    				$com = $resultado[$value->idbranch]['commerces'];
	    					if($com->tags->count() > 0) {
				    			$commerces[$k] = $resultado[$value->idbranch]['commerces'];
	    					} else {
	    						unset($branchs[$key]);
	    					}
		    			} else {
			    			$commerces[$k] = $resultado[$value->idbranch]['commerces'];
		    			}

		    			//$value->commerce = $resultado[$value->idbranch]['commerces'];
		    			//$commerces[$k] = $resultado[$value->idbranch]['commerces'];
		    			$k++;
		    		}
		    		
		    	}
*/
/*		    			return $commerces;

		    	$branchs['total'] = $paginate['total'];
		    	$branchs['current_page'] = $paginate['current_page'];
		    	$branchs['per_page'] = $paginate['per_page'];
		    	$branchs['last_page'] = $paginate['last_page'];
		    	$branchs['from'] = $paginate['from'];
		    	$branchs['to'] = $paginate['to'];
*/		    	
//		    	$data=[];
//		    	$data['commerces'] = $branchs;

//		    	$data = $branchs;

//		    	$pagination = $this->getPagination($commerces, $limit);
		    	$pagination = $this->getPagination($resultado, $limit);
				
				return response()->json([
										'success'    => true, 
										//'data'       => $data,
										//'paginate'   => $paginate,
										'data' =>$pagination
										], 200);
				break;

	    	case 'discount':
 				$query = Discount::with('categories','tags')
 						->with(['branchs' =>function ($query) {
                            $query->with('commerces');
                        }]);
 				
 				$query->whereHas('branchs', function($q) use($branch) {
                	$q->whereIn('idbranch',$branch);
                });

                if($request->category_discount) {
					$category_discount = $request->category_discount;
                    $query->where('discountcategory_iddiscountcategory', $request->category_discount);
                }

                if($request->word) {			  					
					//realiza opciones de limpiado, conversion minuscula, etc
					$word = $this->getWord($request->word);
					//Incluir elemento del array obtenido
					foreach ($word as $value) {
						if($value === reset($word)){
							$query->where('title','like','%'.$value.'%');
						} else {
							$query->orWhere('title','like','%'.$value.'%');
						}
					}
			  	}

                if($request->tags && count($request->tags) > 0) {
                	$tags = $request->tags;
                    foreach ($tags as $value) {
                       $query->WhereHas('tags', function ($query) use ($value) {
                                            $query->where('idtags',$value);
                                        });
                    }
                }

	    		$query = $query->paginate($limit);
	    		
	    		$paginate = $this->getPaginate($query);

	    		$res = [];
	    		$resultado = [];
	    		$val_ant = 0;

				foreach ($query as $key => $value) {
					foreach($value->branchs as $temp){
						
						$r = array_search($temp->idbranch, $branchsOrder);
						
						$res[$temp->idbranch] = $r;
						
						/*if($r >= 0) {
							if($val_ant>$r || $val_ant == $r) {
								unset($resultado[$val_ant]);
								$resultado[$r] = $value;
								$val_ant = $r;
							} else {
								$resultado[$r] = $value;
								$val_ant = $r;
							}
						}*/

					}
		      		//$resultado[$value->idbranch] =$value;	
		      	}
return $res;
/*	    		$k=1;
				foreach ($query as $key => $value) {
					if($value->branchs->count() > 0) {
			      		foreach ($value->branchs as $k => $val) {
			      			$r = array_search($val->idbranch,$branchs);
			      			if($r) {
			      				$branchs[$r] = $value->branchs; 
			      			}
			      		}

			      		//$resultado[$k] = $value;
			      		//$k++;	
					} else {
		    			unset($branchs[$key]);
					}	
		      		
		      		//$resultado[$value->idbranch] = $value;	
		      	}


return $resultado;


		      	$discounts=[];
		      	$k = 1;
		      	//Ordena el resultado obtenido por distancia ASC
		    	foreach ($branchs as $key => $value) {
		    		return $resultado[$value->idbranch]['discounts'];
		    		if($resultado[$value->idbranch]['discounts']->count() == 0){
		    			unset($branchs[$key]);
		    		} else {
		    			//$value->discount = $resultado[$value->idbranch]['discounts'];
		    			if($request->tags) {
		    				$dis = $resultado[$value->idbranch]['discounts'];
		    				foreach ($dis as $k => $val) {
		    					if($val->tags->count() > 0) {
		    						$discounts[$k] = $resultado[$value->idbranch]['discounts'];
		    					} else {
		    						unset($branchs[$key]);
		    					}
		    				}	
		    			} else {
			    			$discounts[$k] = $resultado[$value->idbranch]['discounts'];
		    			}
		    			$k++;
		    		}		    		
		    	}
$discounts;*/
				/*$discounts['total'] = $paginate['total'];
		    	$discounts['current_page'] = $paginate['current_page'];
		    	$discounts['per_page'] = $paginate['per_page'];
		    	$discounts['last_page'] = $paginate['last_page'];
		    	$discounts['from'] = $paginate['from'];
		    	$discounts['to'] = $paginate['to'];
		    	*/

//		    	$data=[];
//		    	$data['discounts'] = $branchs;
		    	//$data = $discounts;
		    	//$pagination = $this->getPagination($discounts, $limit);
		    	$pagination = $this->getPagination($resultado, $limit);
				
				return response()->json([
										'success'    => true, 
										//'data' 	     => $data,
										//'paginate' 	 => $paginate,
										'data' => $pagination
										], 200);
	    		break;
	    
	    	default:
	      		return response()->json(['error' => 'Se requiere el tipo de busqueda a realizar'], 422);
	      		break;
	    }

	}


    protected function getLocalizationUser()
    {
    	$id_user = 1;//"851e91410915be4dbd49";

  		$user= User::find($id_user); 

	  	$localization = [];

	  	if(isset($user)) {
		  	$localization['latitude']  = $user->latitude;
		  	$localization['longitude'] = $user->longitude;	  		
	  	} else {
	  		$coord = $this->getCoordenateDefault();
	  		$coord = json_decode($coord['val'], true);

		  	$localization['latitude']  = $coord['latitud'];
		  	$localization['longitude'] = $coord['longitud'];	  			  		
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
            'word'  => 'nullable|string',
            'offset'=> 'integer'
        ]);
    }

    protected function getPagination($array)
    {
    	//Numero de registro a mostrar por pagina 
      	$perPag = $this->getPerPage();
      	$perPag = intval($perPag->val);

    	// Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($array);
 
        // Define how many items we want to be visible in each page
        $perPage = $perPag; //1;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath(\Config::get('app.url').'/api/search');
 
        return $paginatedItems;
    }


    public function getSearchs(Request $request)
    {
        //Limite de sucursales a devolver
		$limit = $this->getLimit();
		$limit = intval($limit->val);

		if(!$request->offset) {
			$offset = 0;
		} else {
			$offset = $request->offset;
		}
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

			$branchs = DB::select('call sp_getbranch_from_location(?,?,?,?,?,?)', array($local_user['latitude'],$local_user['longitude'],$rango1,$rango2,$limit,$offset));

			if(count($branchs) > 0) {
				break;
			}

			$ri++;
		}

      	$branch = array();
      	foreach ($branchs as $key => $value) {
      		$branch[] = $value->idbranch; 
      	}

		$query = Discount::with('categories','tags')->with(['branchs' =>function ($query) use($branch) {
                            $query->with('commerces');
                            $query->whereIn('idbranch',$branch);
                        }]);

                if($request->category_discount) {
					$category_discount = $request->category_discount;
                    $query->where('discountcategory_iddiscountcategory', $request->category_discount);
                }

                if($request->word) {			  					
					//realiza opciones de limpiado, conversion minuscula, etc
					$word = $this->getWord($request->word);
					//Incluir elemento del array obtenido
					foreach ($word as $value) {
						if($value === reset($word)){
							$query->where('title','like','%'.$value.'%');
						} else {
							$query->orWhere('title','like','%'.$value.'%');
						}
					}
			  	}

                if($request->tags && count($request->tags) > 0) {
                	$tags = $request->tags;
                    foreach ($tags as $value) {
                       $query->WhereHas('tags', function ($query) use ($value) {
                                            $query->where('idtags',$value);
                                        });
                    }
                }

                return $query->get();
                

                
    }


	public function getSearchOld(Request $request)
	{
		$validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        //Limite de sucursales a devolver
		$limit = $this->getLimit();
		$limit = intval($limit->val);

		if(!$request->offset) {
			$offset = 0;
		} else {
			$offset = $request->offset;
		}
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

			$branchs = DB::select('call sp_getbranch_from_location(?,?,?,?,?,?)', array($local_user['latitude'],$local_user['longitude'],$rango1,$rango2,$limit,$offset));

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

							}])
							->whereIn('idbranch',$branch);

	    		$query = $query->paginate($limit);
	    		//$query = $query->get();
	 			
	 			$paginate = $this->getPaginate($query, $limit);

				$resultado = [];

				foreach ($query as $key => $value) {
		      		$resultado[$value->idbranch] =$value;	
		      	}

		      	$commerces= [];
		      	$k=1;
				//Ordena el resultado obtenido por distancia
		    	foreach ($branchs as $key => $value) {
		    		if($resultado[$value->idbranch]['commerces'] == ""){
		    			unset($branchs[$key]);
		    		} else {
		    			if($request->tags) {
		    				$com = $resultado[$value->idbranch]['commerces'];
	    					if($com->tags->count() > 0) {
				    			$commerces[$k] = $resultado[$value->idbranch]['commerces'];
	    					} else {
	    						unset($branchs[$key]);
	    					}
		    			} else {
			    			$commerces[$k] = $resultado[$value->idbranch]['commerces'];
		    			}

		    			//$value->commerce = $resultado[$value->idbranch]['commerces'];
		    			//$commerces[$k] = $resultado[$value->idbranch]['commerces'];
		    			$k++;
		    		}
		    		
		    	}

/*		    			return $commerces;

		    	$branchs['total'] = $paginate['total'];
		    	$branchs['current_page'] = $paginate['current_page'];
		    	$branchs['per_page'] = $paginate['per_page'];
		    	$branchs['last_page'] = $paginate['last_page'];
		    	$branchs['from'] = $paginate['from'];
		    	$branchs['to'] = $paginate['to'];
*/		    	
//		    	$data=[];
//		    	$data['commerces'] = $branchs;

//		    	$data = $branchs;

		    	$pagination = $this->getPagination($commerces, $limit);
				
				return response()->json([
										'success'    => true, 
										//'data'       => $data,
										//'paginate'   => $paginate,
										'data' =>$pagination
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
	    		
	    		$paginate = $this->getPaginate($query);


	    		$resultado = [];

				foreach ($query as $value) {
		      		$resultado[$value->idbranch] = $value;	
		      	}

		      	$discounts=[];
		      	$k = 1;
		      	//Ordena el resultado obtenido por distancia ASC
		    	foreach ($branchs as $key => $value) {
		    		if($resultado[$value->idbranch]['discounts']->count() == 0){
		    			unset($branchs[$key]);
		    		} else {
		    			//$value->discount = $resultado[$value->idbranch]['discounts'];
		    			if($request->tags) {
		    				$dis = $resultado[$value->idbranch]['discounts'];
		    				foreach ($dis as $k => $val) {
		    					if($val->tags->count() > 0) {
		    						$discounts[$k] = $resultado[$value->idbranch]['discounts'];
		    					} else {
		    						unset($branchs[$key]);
		    					}
		    				}	
		    			} else {
			    			$discounts[$k] = $resultado[$value->idbranch]['discounts'];
		    			}
		    			$k++;
		    		}		    		
		    	}
$discounts;
				/*$discounts['total'] = $paginate['total'];
		    	$discounts['current_page'] = $paginate['current_page'];
		    	$discounts['per_page'] = $paginate['per_page'];
		    	$discounts['last_page'] = $paginate['last_page'];
		    	$discounts['from'] = $paginate['from'];
		    	$discounts['to'] = $paginate['to'];
		    	*/

//		    	$data=[];
//		    	$data['discounts'] = $branchs;
		    	//$data = $discounts;
		    	$pagination = $this->getPagination($discounts, $limit);
				
				return response()->json([
										'success'    => true, 
										//'data' 	     => $data,
										//'paginate' 	 => $paginate,
										'data' => $pagination
										], 200);
	    		break;
	    
	    	default:
	      		return response()->json(['error' => 'Se requiere el tipo de busqueda a realizar'], 422);
	      		break;
	    }

	}

	
}
