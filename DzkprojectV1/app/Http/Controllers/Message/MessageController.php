<?php

namespace App\Http\Controllers\Message;

use App\Follower;
use App\Http\Controllers\Controller;
use App\MessengerService;
use App\UserContactChat;
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
    
    public function messageSendAll(Request $request){

      $fields = $request->all();

      $followers = Follower::where('commerce_idcommerce', $fields['commerce_idcommerce'])->get();

      foreach ($followers as  $follower) {
        
          $fields['idmessengerservice'] = str_random(36);
          $fields['thread'] = str_random(30);
          $fields['users_id_to'] = $follower->users_id;
          $message = MessengerService::create($fields);
      }

      return response()->json(['data'=> 'success'], 200);

    }   

    public function messageSendConversation(Request $request){

      $fields = $request->all();

      $fields['idmessengerservice'] = str_random(36);

      if($request->users_id_to){

        $existe = UserContactChat::where('users_id',$request->users_id_from)->where('contactuser_id', $request->users_id_to)->first();

          if (!$existe) {
              $data = [
                'iduserscontactchat'  => str_random(36),
                'users_id'      => $request->users_id_from,
                'contactuser_id'    => $request->users_id_to,
                'commerce_idcommerce'    => $request->commerce_idcommerce,
              ];

              UserContactChat::create($data);
          }
      }

      $message = MessengerService::create($fields);

      return response()->json(['data'=> $message], 200);

    }    

    public function index($id){

      $data = UserHasCommerce::where('users_id', $id)->first();

      $messages = MessengerService::where('users_id_from', $id)->orWhere('users_id_to', $id)->orderBy('created_at', 'DES');

      if($data){

       $messages =  $messages->orWhere('commerce_idcommerce', $data->commerce_idcommerce);
      }

      $messages = $messages->with(['from', 'commerce'])->get()->unique('thread')->where('messengerservicetopic_idmessengerservicetopic', 1);
   
      return response()->json(['data'=> $messages], 200);

    }    

    public function find($id){

      $messages = MessengerService::where('thread', $id)->where('messengerservicetopic_idmessengerservicetopic', 1)->orderBy('created_at', 'ASC')->get();

      return response()->json(['data'=> $messages], 200);

    }    

    public function read($id){

      $message = MessengerService::find($id);

      $message->read_at = 1;

      $message->save();

      return response()->json(['data'=> $message], 200);

    }      

    public function chatUsers($id){

      $users = UserContactChat::where('users_id', $id)->with(['user','contact'])->get();
   
      return response()->json(['data'=> $users], 200);

    }       

    public function messageSendChat(Request $request){

      $fields = $request->all();

      $fields['idmessengerservice'] = str_random(36);

      if (!$request->thread) {
      
         $fields['thread'] = str_random(30);
      }


      $message = MessengerService::create($fields);

      return response()->json(['data'=> $message], 200);

    }       
    public function findThreadChat($user, $contact){

      $thread = MessengerService::where('users_id_from', $user)->where('users_id_to', $contact)->where('messengerservicetopic_idmessengerservicetopic', 2)->first();

      if(!$thread){
        $thread = MessengerService::where('users_id_from', $contact)->where('users_id_to', $user)->where('messengerservicetopic_idmessengerservicetopic', 2)->first();
      }


      $messages = MessengerService::where('thread', $thread->thread)->orderBy('created_at', 'ASC')->get();


      return response()->json(['data'=> $messages], 200);

    }   

}
