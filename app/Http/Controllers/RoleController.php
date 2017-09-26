<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest;
use Auth;

class RoleController extends Controller{

    private $title;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->title = 'Role';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(!Auth::user()->can('role.list'))
            return abort(401);


        $roles = Role::all();
        $title = $this->title;
        $addurl = route('roles.create');
        
        return view('bo.roles.index', compact('title', 'roles', 'addurl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!Auth::user()->can('role.create'))
            return abort(401);
        $title = $this->title;
        $permissions = Permission::orderBy('name')->get();
        return view('bo.roles.create', compact('title', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request){
        $permissions = $request->to;
        $role = Role::create(['name' => $request->name]);
        foreach ($permissions as $perm) {
            $role->givePermissionTo($perm);
        }
        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if(!Auth::user()->can('role.update'))
            return abort(401);
        $title = $this->title;
        $role = Role::find($id);
        $ownedperms = $role->permissions;
        $permissions = Permission::whereNotIn('id', $ownedperms->pluck('id'))->orderBy('name')->get();
        if($role)
            return view('bo.roles.edit', compact('title', 'role', 'ownedperms', 'permissions'));
        else
            return redirect('/roles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id){
        $permissions = $request->to;
        $role = Role::find($id);
        $role->name = $request->name;
        $role->update();
        if(!empty($permissions))
            $role->syncPermissions($permissions);
        else
            $role->syncPermissions([]);
        
        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if(!Auth::user()->can('role.delete'))
            return abort(401);
        
        $role = Role::find($id);
        $role->delete();
        return redirect('/roles');
    }
}
