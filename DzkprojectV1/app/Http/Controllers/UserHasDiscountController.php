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
        $uhd = UserHasDiscount::with('discounts')->where('commerce_idcommerce', 'e1C1ug06cTODmclayIKnzKHpRdRlBkS7nIMJ')->paginate(2); //Selecciono los descuentos que sean igual al comercio conectado. Por ahora, estatico.

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
}
