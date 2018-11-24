<?php

namespace App\Http\Controllers\MarketPlaceListing;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MarketPlaceListing;
use App\MarketPlaceListingDetail;
use App\Http\Requests\MarketPlaceListingRequest;
use Illuminate\Support\Facades\DB;

class MarketPlaceListingController extends Controller
{
    public function index()
    {
    	$lists = MarketPlaceListing::all();
    	
        return response()->json(['success'=>true, 'data'=>$lists], 200);   
    }

    public function store(MarketPlaceListingRequest $request)
    {
  
    	try{
    	    DB::transaction(function () use($request){
       
    	    	$request->merge(['idmarketplacelisting' => str_random(36)]);
        
		        $request->merge(['users_id' => Auth::id()]);

            	$marketplace = MarketPlaceListing::create(
            		$request->all()
            	);

            	if($request->detalle && count($request->detalle) > 0) {
	            	foreach ($request->detalle as $temp) {
						$idmarketplacelistingdetail = str_random(36);
						//$marketplace->details()->create([
						MarketPlaceListingDetail::create([
							'idmarketplacelistingdetail' => $idmarketplacelistingdetail,
							'quantity' => $temp['quantity'],
							'unitprice' => $temp['unitprice'],
							'taxes' => $temp['taxes'],
							'totalprice' => ($temp['quantity'] * $temp['unitprice']) + $temp['taxes'],
							'marketplacelisting_idmarketplacelisting' => $request->idmarketplacelisting,
							'product_idproduct' => $temp['product_idproduct'],
							'productunitofmeasurement_idproductunitofmeasurement' => $temp['productunitofmeasurement_idproductunitofmeasurement'],
							'commerce_idcommerce' => $request->commerce_idcommerce,
							'branch_idbranch' => $temp['branch_idbranch'], //Preguntar
							'users_id' => $request->users_id,
							'statelisting_idstatelisting' => $temp['statelisting_idstatelisting'] //Revisar  
						]);
	            	}
            	}

            	$totaltaxes = MarketPlaceListingDetail::select(DB::raw('SUM(taxes) as taxes'))
            		->where('marketplacelisting_idmarketplacelisting',$request->idmarketplacelisting)
            			->first();

            	$totalprice = MarketPlaceListingDetail::select(DB::raw('SUM(totalprice) as total'))
            		->where('marketplacelisting_idmarketplacelisting',$request->idmarketplacelisting)
            			->first();

            	$marketplacelisting = MarketPlaceListing::find($request->idmarketplacelisting);
            	$marketplacelisting->initprice = $totalprice->total;
            	$marketplacelisting->inittaxes = $totaltaxes->taxes;
            	$marketplacelisting->inittotalprice = $totalprice->total + $totaltaxes->taxes;
            	$marketplacelisting->save();
            	

            });
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['success'=>'Lista de Compra creada'], 200);   
    }

    public function update(MarketPlaceListingRequest $request, $id)
    {

    	$markeplace = MarketPlaceListing::find($id);

    	if(!$marketplace ){
            return response()->json(['error' => 'Error no existe lista'], 422);
        }

    	if($request->detalle && count($request->detalle) > 0) {
	            	foreach ($request->detalle as $temp) {
						$idmarketplacelistingdetail = str_random(36);

						MarketPlaceListingDetail::create([
							'idmarketplacelistingdetail' => $idmarketplacelistingdetail,
							'quantity' => $temp['quantity'],
							'unitprice' => $temp['unitprice'],
							'taxes' => $temp['taxes'],
							'totalprice' => ($temp['quantity'] * $temp['unitprice']) + $temp['taxes'],
							'marketplacelisting_idmarketplacelisting' => $request->idmarketplacelisting,
							'product_idproduct' => $temp['product_idproduct'],
							'productunitofmeasurement_idproductunitofmeasurement' => $temp['productunitofmeasurement_idproductunitofmeasurement'],
							'commerce_idcommerce' => $request->commerce_idcommerce,
							'branch_idbranch' => $temp['branch_idbranch'], //Preguntar
							'users_id' => $request->users_id,
							'statelisting_idstatelisting' => $temp['statelisting_idstatelisting'] //Revisar  
						]);

						MarketPlaceListingDetail::updateOrCreate([
		                    'marketplacelisting_idmarketplacelisting'   => $marketplace->idmarketplacelisting,
		                    'commerce_idcommerce' => $value['commerce_idcommerce'],
		                    'branch_idbranch'     => $value['idbranch']
		                ],[
		                    'stock' => $value['stock'],
		                    'idbranch_has_product' => $idbranch_has_product
		                ]);
	            	}
            	}

            	$totaltaxes = MarketPlaceListingDetail::select(DB::raw('SUM(taxes) as taxes'))
            		->where('marketplacelisting_idmarketplacelisting',$request->idmarketplacelisting)
            			->first();

            	$totalprice = MarketPlaceListingDetail::select(DB::raw('SUM(totalprice) as total'))
            		->where('marketplacelisting_idmarketplacelisting',$request->idmarketplacelisting)
            			->first();

            	$marketplacelisting = MarketPlaceListing::find($request->idmarketplacelisting);
            	$marketplacelisting->initprice = $totalprice->total;
            	$marketplacelisting->inittaxes = $totaltaxes->taxes;
            	$marketplacelisting->inittotalprice = $totalprice->total + $totaltaxes->taxes;
            	$marketplacelisting->save();
            	


    }

    public function getActive($user)
    {
    	$list = MarketPlaceListing::where('user_id',$user)
    				->where('applicationdate',NULL)
    					->get();
        
        return response()->json(['success'=>true, 'data'=>$list], 200);   

    }

}
