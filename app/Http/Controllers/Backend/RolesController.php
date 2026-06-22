<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        $All_permissions = Permission::all();
        $group_permissions = User::group_byName();
        return view('backend.user.permission.create_role',compact('roles','All_permissions','group_permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate input
        $request->validate([
           'rolename'=> 'required:unique:roles,name'
        ]);
        $role = $request->rolename;
        $permissions = $request->permissions;
        $role = Role::create(['name' => $role]);
        if (!empty($permissions))
        {
            $role->syncPermissions($permissions);
        }

       return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findById($id);
        $All_permissions = Permission::all();
        $group_permissions = User::group_byName();
        return view('backend.user.permission.edit_role',compact('role','All_permissions','group_permissions'));
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
        // dd($request->all());
        $request->validate([
            'rolename'=> 'required'
        ]);
        $permissions = $request->permissions;
        $rolename    = $request->rolename;
        $role = Role::findById($id);

        if (!empty($permissions))
        {
            $role->syncPermissions($permissions);
        }
        $role->name = $rolename;
        $role->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function permissionStore(Request $request)
    {

        $group_name = $request->permission_group_name;
        $permissions = $request->permission_name;
        foreach ($permissions as $permission)
        {
            $this->permmission($group_name,$permission);
        }
        return redirect()->back()->with('message','Permission Save Successfully !');

    }
    public function permmission($group_name,$permission)
    {
        $permission_store = new Permission();
        $permission_store->name = $permission;
        $permission_store->guard_name = 'web';
        $permission_store->group_name = $group_name;
        $permission_store->save();
    }

    public function permissionList()
    {
        $permissions = Permission::all();
        return view('backend.user.permission.permission-list',compact('permissions'));
    }
    public function permissionUpdate(Request $request)
    {

        $permission_id = $request->permission_group_id;
        $permission = Permission::findorFail($permission_id);
        $permission->name = $request->permission_name;
        $permission->group_name = $request->permission_group_name;
        $permission->save();
        return redirect()->back()->with('message','permission update successfully!');
    }

    public function permissionDelete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->back()->with('message','permission delete successfully !');
    }
}
