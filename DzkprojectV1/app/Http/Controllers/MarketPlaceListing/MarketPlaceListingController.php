<?php

namespace App\Http\Controllers\MarketPlaceListing;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MarketPlaceListing;
use App\MarketPlaceListingDetail;
use App\Http\Requests\MarketPlaceListingRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Lang;

class MarketPlaceListingController extends Controller
{
    public function index()
    {
    	$lists = MarketPlaceListing::all();
    	
        return response()->json(['success'=>true, 'data'=>$lists], 200);   
    }

    public function store(MarketPlaceListingRequest $request)
    {  
       
    	$request->merge(['idmarketplacelisting' => str_random(36)]);

        $request->merge(['users_id' => Auth::id()]);

    	$marketplace = MarketPlaceListing::create(
    		$request->all()
    	);

    	if(is_array($request->detalle) && count($request->detalle) > 0 ) {

        	$this->addProduct($request->all());
    	
        	$this->totalListMarket($request->idmarketplacelisting);

    	}

        if(!$marketplace) {
        	return response()->json(['error'=>'Error al guardar'], 422);   
        }

        return response()->json(['success'=>true,'data'=>$marketplace], 200);   

    }

    public function update(MarketPlaceListingRequest $request, $id)
    {

    	$marketplace = MarketPlaceListing::find($id);

    	if( !$marketplace ){
            return response()->json(['error' => 'Error no existe lista'], 422);
        }

		$request->merge(['users_id' => Auth::id()]);

        try{
    	    DB::transaction(function () use($request){    	    	

		      	if(is_array($request->detalle) && count($request->detalle) > 0 ) {
		      		$this->addProduct($request->all());

		      		$this->totalListMarket($request->idmarketplacelisting);
		      	}

			});
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['success'=>true], 200);   
    }

    public function show($id)
    {
    	$marketPlaceListing = MarketPlaceListing::where('idmarketplacelisting',$id)
    							->with(['details'=>function($query) {
    								$query->with(['product' => function($query) {
    									$query->orderBy('name','ASC');
    								}]);
    							}])
    								->get();

		return response()->json(['success'=>true, 'data'=>$marketPlaceListing], 200);  
    }

    protected function addProduct($data)
    {
       	foreach ($data['detalle'] as $temp) {
			$idmarketplacelistingdetail = str_random(36);

			MarketPlaceListingDetail::updateOrCreate([
		        'marketplacelisting_idmarketplacelisting'   => $data['idmarketplacelisting'],
		        'commerce_idcommerce' => $data['commerce_idcommerce'],
		        'branch_idbranch'     => $data['branch_idbranch'],
				'product_idproduct' => $temp['product_idproduct']
		    ],[
		        'idmarketplacelistingdetail' => $idmarketplacelistingdetail,
				'quantity' => $temp['quantity'],
				'unitprice' => $temp['unitprice'],
				'taxes' => $temp['taxes'],
				'totalprice' => ($temp['quantity'] * $temp['unitprice']) + $temp['taxes'],
				'marketplacelisting_idmarketplacelisting' => $data['idmarketplacelisting'],
				'product_idproduct' => $temp['product_idproduct'],
				'productunitofmeasurement_idproductunitofmeasurement' => $temp['productunitofmeasurement_idproductunitofmeasurement'],
				'commerce_idcommerce' => $data['commerce_idcommerce'],
				'branch_idbranch' => $data['branch_idbranch'], 
				'users_id' => $data['users_id'],
				'statelisting_idstatelisting' => $temp['statelisting_idstatelisting']
		    ]);
		}
    }

    protected function totalListMarket($idmarketplacelisting)
    {
    	$totaltaxes = MarketPlaceListingDetail::select(DB::raw('SUM(taxes) as taxes'))
            		->where('marketplacelisting_idmarketplacelisting',$idmarketplacelisting)
            			->first();

    	$totalprice = MarketPlaceListingDetail::select(DB::raw('SUM(unitprice*quantity) as total'))
    		->where('marketplacelisting_idmarketplacelisting',$idmarketplacelisting)
    			->first();

    	$marketplacelisting = MarketPlaceListing::find($idmarketplacelisting);
    	$marketplacelisting->initprice = $totalprice->total;
    	$marketplacelisting->inittaxes = $totaltaxes->taxes;
    	$marketplacelisting->inittotalprice = $totalprice->total + $totaltaxes->taxes;
    	$marketplacelisting->save();
    }

    public function deleteProduct($id)
    {
      $marketDetail = MarketPlaceListingDetail::find($id);


      if(!$marketDetail) {
          return response()->json(['error' => 'No existe el detalle.'], 422);
      }

      $marketDetail->delete();

      $this->totalListMarket($marketDetail->marketplacelisting_idmarketplacelisting);

      return response()->json(['success'=>'Ok'],200);
    }

    public function setOrderMarketList(Request $request, $id)
    {
    	$marketPlaceListing = MarketPlaceListing::find($id);

		if(!$marketPlaceListing) {
          return response()->json(['error' => 'No existe el listado.'], 422);
      	}

    	/*$totaltaxes = MarketPlaceListingDetail::select(DB::raw('SUM(taxes) as taxes'))
            		->where('marketplacelisting_idmarketplacelisting',$marketPlaceListing->idmarketplacelisting)
            			->first();

    	$totalprice = MarketPlaceListingDetail::select(DB::raw('SUM(unitprice*quantity) as total'))
    		->where('marketplacelisting_idmarketplacelisting',$marketPlaceListing->idmarketplacelisting)
    			->first();*/

    	$marketPlaceListing->applicationdate = Carbon::now();
    	if(!is_null($request->feedback))
    		$marketPlaceListing->observations = $request->observations;
    	//$marketPlaceListing->finalprice = $totalprice->total;
    	//$marketPlaceListing->finaltaxes = $totaltaxes->taxes;
    	//$marketPlaceListing->finaltotalprice = $totalprice->total + $totaltaxes->taxes;
    	
    	if( $marketPlaceListing->save()) {
     		return response()->json(['success'=>\Lang::get('messages.order_created')],200);
    	}


    }

    public function getRequestsUser()
    {
    	$user = Auth::id();

    	$lists = MarketPlaceListing::where('users_id',$user)
    			->with('commerce')
    				->with('branch')
	    				->with(['details' => function($query) {
	    					$query->with('product');
	    					$query->with('state');
	    				}])
	    					->get();

        return response()->json(['success'=>true, 'data'=>$lists], 200);   

    }

    public function getActive($commerce,$branch,$user = null)
    {
    	if(is_null($user)) {
    		$user = Auth::id();
    	} 

    	$list = MarketPlaceListing::where('users_id',$user)
    				->where('commerce_idcommerce',$commerce)
    					->where('branch_idbranch',$branch)
    						->where('applicationdate',NULL)
    							->get();

        return response()->json(['success'=>true, 'data'=>$list], 200);   

    }
}
