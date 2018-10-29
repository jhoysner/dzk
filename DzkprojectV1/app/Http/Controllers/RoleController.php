<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Authorizable;
use App\Permission;
use App\Role;
use Lang;

class RoleController extends Controller
{
    //use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return response()->json(['roles'=>$roles,'permissions'=>$permissions], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $role = Role::create($request->only('name'));

        if( !$role ) {
            return response()->json(['error' => \Lang::get('messages.role_error_create')], 422);
        }
        
        return response()->json(['success'=>\Lang::get('messages.role_create')], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::find($id);

        if( !$rol ) {
            return response()->json(['error' => \Lang::get('messages.role_error_found')], 422);
        }

        return response()->json(['success'=>true,'rol'=>$rol], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if($request->name) {
            
            $rol = Role::findOrFail($id);

            if( !$rol ) {
                return response()->json(['error' => \Lang::get('messages.role_error_update')], 422);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,'.$rol->id,
            ]);

            if($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 422);
            }

            $rol->name = $request->name;
            $rol->save();
            
            return response()->json(['success'=>\Lang::get('messages.role_update')], 200);

        }        

        if($role = Role::findOrFail($id)) {
            if($role->name == 'Admin') {
                $role->syncPermissions(Permission::all());
            }

            $permissions = $request->all(); 

            $role->syncPermissions($permissions);
            
            return response()->json(['success'=>\Lang::get('messages.permissions_update')], 200);
        } else {
            return response()->json(['error' => \Lang::get('messages.permissions_error_update')], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Role::destroy($id);

        if(!$rol){
            return response()->json(['error' => 'No existe el Grupo'], 422);
        }

        return response()->json(['success'=>\Lang::get('messages.role_delete')], 200);
    }

    public function getPermisosRoles($id)
    {
        $rol = Role::find($id);

        $permissions = Permission::all();

        $perm = [];

        foreach ($permissions as $key => $value) {
            $permiso = $rol->hasPermissionTo($value->name);            
            
            if($permiso) {
                $perm[] = $value->id;
            }
        }

        return $perm;
    }

}
