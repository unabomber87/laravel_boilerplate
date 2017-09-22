<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller{

    private $title;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->title = 'role';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
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
    public function store(Request $request){
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
    public function update(Request $request, $id){
        $permissions = $request->to;
        $role = Role::find($id);
        $role->name = $request->name;
        $role->update();

        $role->syncPermissions($permissions);
        
        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $role = Role::find($id);
        $role->delete();
        return redirect('/roles');
    }
}
