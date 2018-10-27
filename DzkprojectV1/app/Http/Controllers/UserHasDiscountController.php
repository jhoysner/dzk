<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Commerce;
use App\Discount;
use App\Http\Controllers\Controller;
use App\UserHasDiscount;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;

class UserHasDiscountController extends Controller
{
    public function listUserHasDiscount()
    {
        $uhd = UserHasDiscount::with('discounts')
                ->with('discountsStatus')
                    ->where('commerce_idcommerce', 'c26a0461-caa4-11e8-89ee-74c63b1404ed')->paginate(2); //Selecciono los descuentos que sean igual al comercio conectado. Por ahora, estatico. Luego, será a través de una relación usuario conectado con la tabla users_has_commerce.

        return response()->json([
            'paginate' => [
                'total'         =>  $uhd->total(),
                'current_page'  =>  $uhd->currentPage(),
                'per_page'      =>  $uhd->perPage(),
                'last_page'     =>  $uhd->lastPage(),
                'from'          =>  $uhd->firstItem(),
                'to'            =>  $uhd->lastPage()
            ],

            'data' => $uhd

        ],200);
    }

    public function authorizeDiscount($id)
    {
        $uhd = UserHasDiscount::where('idusers_has_discount', $id);

        $uhd->update(['userhasdiscountstatus_iduserhasdiscountstatus' => 2]);

        return response()->json([
            'success' => true,
            'msg'   =>  'Has declarado esta solicitud como autorizada.'
        ]);
    }

    public function notAuthorize($id)
    {
        $uhd = UserHasDiscount::where('idusers_has_discount', $id);

        $uhd->update(['userhasdiscountstatus_iduserhasdiscountstatus' => 4]);

        return response()->json([
            'success' => true,
            'msg'   =>  'Has declarado esta solicitud como no autorizada.'
        ]);
    }

    public function cancelDiscount($id)
    {
        $uhd = UserHasDiscount::where('idusers_has_discount', $id);

        $uhd->update(['userhasdiscountstatus_iduserhasdiscountstatus' => 5]);

        return response()->json([
            'success' => true,
            'msg'   =>  'Has cancelado esta solicitud.'
        ]);
    }

    public function searchCharcode($charcode)
    {
        $count = UserHasDiscount::with('discounts')
                ->with('discountsStatus')
                    ->where('charcode', 'LIKE', '%'.$charcode.'%')->count();

        $uhd = UserHasDiscount::with('discounts')
                ->with('discountsStatus')
                    ->where('charcode', 'LIKE', '%'.$charcode.'%')->get();


        if($count > 0) {
            return response()->json([
                'success' => true,
                'msg'   =>  'Descuento encontrado.',
                'data'  =>  $uhd
            ]);
        }

        return response()->json([
            'success' => false,
            'msg'   =>  'No existen descuentos con este código.'
        ]);
    }

    public function redeemedDiscount($id)
    {
        $uhd = UserHasDiscount::where('idusers_has_discount', $id);

        $uhd->update(['userhasdiscountstatus_iduserhasdiscountstatus' => 3]);

        return response()->json([
            'success' => true,
            'msg'   =>  '¡Has redimido la solicitud exitosamente!.'
        ]);
    }
}
