<?php

namespace App\Http\Controllers\Follow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function follow($id,$commerce){
      dd($id ." " .$commerce);
    }
}
