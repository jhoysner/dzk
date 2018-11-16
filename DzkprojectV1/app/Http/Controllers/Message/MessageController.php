<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\MessengerService;
use App\UserHasCommerce;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function messageSend(Request $request){

      $fields = $request->all();

      $fields['idmessengerservice'] = str_random(36);

      if (!$request->thread) {
      
         $fields['thread'] = str_random(30);
      }


      $message = MessengerService::create($fields);

      return response()->json(['data'=> $message], 200);

    }        
    public function messageSendConversation(Request $request){

      $fields = $request->all();

      $fields['idmessengerservice'] = str_random(36);

      $message = MessengerService::create($fields);

      return response()->json(['data'=> $message], 200);

    }    

    public function index($id){

      $data = UserHasCommerce::where('users_id', $id)->first();

      $messages = MessengerService::where('users_id_from', $id)->orWhere('users_id_to', $id)->orderBy('created_at', 'DES');

      if($data){

       $messages =  $messages->orWhere('commerce_idcommerce', $data->commerce_idcommerce);
      }

      $messages = $messages->with(['from', 'commerce'])->get()->unique('thread');
   
      return response()->json(['data'=> $messages], 200);

    }    

    public function find($id){

      $messages = MessengerService::where('thread', $id)->orderBy('created_at', 'ASC')->get();

      return response()->json(['data'=> $messages], 200);

    }    

    public function read($id){

      $message = MessengerService::find($id);

      $message->read_at = 1;

      $message->save();

      return response()->json(['data'=> $message], 200);

    }   

}
