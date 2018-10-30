<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Helper;
use App\User;
use App\Params;
use App\Role;
use App\Permission;
use App\Authorizable;
use Storage;
use Lang;
use DB;

class UserController extends Controller
{
    //use Authorizable;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $paginate = Helper::getPaginate();

        $users = User::latest()->paginate($paginate);
        return response()->json(['users'=>$users], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'middlename' => 'string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'min:6|string|required',
            'country_idcountry' => 'required|string',
            'state_idstate' => 'required|string',
            'city_idcity' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }
        
       $data = [
                    'id' => str_random(36),
                    'firstname'  => $request->firstname,
                    'lastname'   => $request->lastname,
                    'email'      => $request->email,
                    'password'   => Hash::make($request->password),
                    'country_idcountry'=> $request->country_idcountry,
                    'state_idstate'    => $request->state_idstate,
                    'city_idcity'      => $request->city_idcity,
                ];


        $user = User::create($data);

        if( !$user ) {
            return response()->json(['error'=>'No se pudo guardar el usuario'], 422);
        }

        if($user) {
            if($request->roles && count($request->roles) > 0) {
                $roles = $request->roles;
                foreach ($roles as $value) {
                    $role = Role::where('id', '=', $value)->first();
                    $user->assignRole($role);    
                }
            }   
        }
         
        return response()->json(['success'=>\Lang::get('messages.user_create')], 200);

    }

    public function show($id) 
    {
        $user = User::where('id','=',$id)
                    ->with('countries')
                    ->with('states')
                    ->with('cities')
                    ->first();

        $roles = $user->roles; 

        if( !$user ) {
            return response()->json(['error'=>'No se pudo guardar el usuario'], 422);
        }

        return response()->json(['user'=>$user,'rol'=>$roles], 200);

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'min:6',
            'country_idcountry' => 'required|string',
            'state_idstate' => 'required|string',
            'city_idcity' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $user = User::find($id);

        if( !$user ) {
            return response()->json(['error'=>'No se pudo guardar el usuario'], 422);
        }

        $user->fill($request->except('rol', 'password'));

        if($request->password) {
            $user->password = bcrypt($request->password);
        }

        if($request->roles && count($request->roles) > 0 ) {
            $roles = $request->roles;
                $user->syncRoles($roles);
        }

        $user->save();

        return response()->json(['success'=>\Lang::get('messages.user_update')], 200);

    }

    public function showProfileForm()
    {
        return view('user.profile');
    }

    public function userDetail() 
    {
        $id = Auth::id();

        $users = User::with('countries')
                    ->with('states')
                    ->with('cities')
                    ->where('id', $id)
                    ->get();
        $user = Auth::user();
        return response()->json(['user'=>$user], 200);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'middlename' => 'string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'min:6|confirmed',
            'phone'=> 'string|max:20',
            'address'=> 'string|max:512',
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

            $path = public_path().'/images/profiles/';

            $imagenInit = $request->file('imagen');
            
            $extension = $imagenInit->getClientOriginalExtension();  

            if ( $user->image != null )
                    if(file_exists($path . $user->image)){
                    unlink($path . $user->image);
                    }

            $temp_name = '/images/profiles/'.$user->id.'.'.$extension;

            $user->image = $temp_name;

            $imagenInit->move($path, $temp_name);                         
            
        }

        $user->save();
        return response()->json(['state'=>'Update','success'=>\Lang::get('messages.user_update'),'user'=>$user], 200);
     
    }

    public function desactivateAccount($id) 
    {

        $user = User::where('id','=', $id)->first();

        $user->delete();

        return response()->json(['success'=>\Lang::get('messages.account_noactive')], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->token;

        $user = Auth::user();

        DB::table('oauth_access_tokens')
            ->where('id', $token)
            ->update([
                'revoked' => true
            ]);

        //$user->revoke();

        return response()->json(['success'=>'Logout User']);
    }

    public function destroy($id)
    {
        $user = User::destroy($id);

        if(!$user){
            return response()->json(['error' => 'No existe el usuario'], 422);
        }

        return response()->json(['state'=>'Delete','success'=>\Lang::get('messages.user_delete'),'user'=>$user], 200);
    }

    public function getPermisosUser($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['error' => 'No existe el usuario'], 422);
        }

        $permissions = $user->permissions;

        if(!$permissions){
            return response()->json(['success'=>'Error al consultar los permisos'], 422);
        }        

         $perm = [];

        foreach ($permissions as $key => $value) {
            $permiso = $user->hasPermissionTo($value->name);            
            
            if($permiso) {
                $perm[] = $value->id;
            }
        }

        return $perm;

    }

    public function asignaPermisosUser(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['error' => 'No existe el usuario'], 422);
        }

         $permisos = $request->all();

         $perm = [];

         foreach ($permisos as $key => $value) {
            $permiso = Permission::find($value);
            if($permiso) {
                $perm[] = $permiso->name;
            }
         }

         $user->syncPermissions($perm);

         return response()->json(['success'=>\Lang::get('messages.user_permissions')], 200);

    }

}
