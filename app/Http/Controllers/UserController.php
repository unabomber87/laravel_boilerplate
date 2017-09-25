<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller{
    private $title;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->title = 'User';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(!Auth::user()->can('user.list'))
            return redirect()->back();

        $users = User::all();
        $title = $this->title;
        $addurl = route('users.create');
        return view('bo.users.index', compact('title', 'users', 'addurl'));
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!Auth::user()->can('user.create'))
            return redirect()->back();
        
        $title = $this->title;
        $roles = Role::all();
        return view('bo.users.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){
        $user = User::create([
		  'name' => $request->name,
		  'email' => $request->email,
		  'password' => bcrypt($request->password)
		]);
        $role = Role::find($request->role);
        $user->syncRoles([$role->name]);
        return redirect('/users');
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
        if(!Auth::user()->can('user.update'))
            return redirect()->back();

        $title = $this->title;
        $user = User::find($id);
        $roles = Role::all();
        if($user)
            return view('bo.users.edit', compact('title', 'user', 'roles'));
        else
            return redirect('/users');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password))
            $user->password = bcrypt($request->password);

        $role = Role::find($request->role);
        $user->syncRoles([$role->name]);
        $user->update();  
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if(!Auth::user()->can('user.delete'))
            return redirect()->back();
        $user = User::find($id);
        $user->delete();
        return redirect('/users');
    }
}
