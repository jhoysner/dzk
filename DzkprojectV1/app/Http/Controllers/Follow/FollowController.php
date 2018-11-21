<?php

namespace App\Http\Controllers\Follow;

use App\User;
use App\Follower;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($id,$commerce){

      $data = [
        'idfollower'  => str_random(36),
        'locked'      => 0,
        'users_id'    => $id,
        'commerce_idcommerce' => $commerce,

      ];
      
      $follow = Follower::create($data);

      if(!$follow){
          return response()->json(['error' => 'No se pudo guardar el registro'], 422);
      }

      return response()->json($follow,  201);

    }      
    public function unfollow($id,$commerce){

      $follow = Follower::where('users_id', $id)->where('commerce_idcommerce', $commerce)->first();

      $follow->delete();

      return response()->json($follow,  201);

    }   

    public function userStateFollow($id,$commerce){
      
      $follow = Follower::where('users_id', $id)->where('commerce_idcommerce', $commerce)->first();

      if(!$follow){
          return response()->json(['state' => false], 201);
      }

      return response()->json(['state' => true],  201);

    }    

    public function userFollowers($id){
      
      $followers = Follower::where('commerce_idcommerce', $id)->with('user')->get();

      return response()->json(['data' => $followers],  201);
    }
}
