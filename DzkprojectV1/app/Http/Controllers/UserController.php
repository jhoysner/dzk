<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Params;
use Storage;
use Lang;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function showProfileForm()
    {
        return view('user.profile');
    }

    public function userDetail($id) 
    {
        $user = User::with('countries')
                    ->with('states')
                    ->with('cities')
                    ->where('id', $id)
                    ->get();

        return response()->json(['user'=>$user], 200);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'confirmed',
            'country_idcountry' => 'required|string',
            'state_idstate' => 'required|string',
            'city_idcity' => 'required|string'
        ]);
    }

    public function updateProfile(Request $request)
    {

        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

    	$userId = $request->userId; //Auth::user()->id;
        $user = User::find($userId);

        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->country_idcountry = $request->country_idcountry;
        $user->state_idstate = $request->state_idstate;
        $user->city_idcity = $request->city_idcity;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ( $request->hasFile('imagen') ) {

            $path = public_path().'/img/profiles/';

            //Obtiene Parametro de la imagen
            $params = $this->paramsImage();

            $imagenInit = $request->file('imagen');
            
            $extension = $imagenInit->getClientOriginalExtension();                        

            if (strpos($params['tipo']['val'], $extension)) {
                $medidas = json_decode($params['medidas']['val']);

                $imagenmed = getimagesize($imagenInit);    //Sacamos la información
                $ancho = $imagenmed[0];              //Ancho
                $alto = $imagenmed[1];

               if($medidas->minsize == $ancho && $medidas->maxsize == $alto) {

                    if ( $user->image != null )
                    if(file_exists($path . $user->image)){
                    unlink($path . $user->image);
                    }

                    $temp_name = '/img/profiles/'.$user->id.'.'.$extension;

                    $user->image = $temp_name;

                    $imagenInit->move($path, $temp_name);    
                }                
                
            }            
            
        }

        $user->save();
        return response()->json(['state'=>'Update','success'=>\Lang::get('messages.user_update'),'user'=>$user], 200);
     
    }

    protected function paramsImage()
    {
        $med = Params::where('key','=','user_img_upload_size')->first();

        $type = Params::where('key','=','user_img_upload_type')->first();

        $img = [];
        $img['medidas'] = $med;
        $img['tipo'] = $type;

        return $img;  
    }

    public function desactivateAccount($id) 
    {

        $user = User::where('id','=', $id)->first();

        $user->delete();

        return response()->json(['success'=>\Lang::get('messages.account_noactive')], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['success'=>'Logout User']);
    }


}
