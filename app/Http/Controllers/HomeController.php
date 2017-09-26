<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //$role = Role::create(['name' => 'admin']);
        // Auth::user()->assignRole('admin');
        // $roles = Auth::user()->getRoleNames();
        // $role = Role::where('name', $roles[0])->first();
        // dd($role);
        // dd(Auth::user()->can('role.list'));
        $title = 'Dashboard';
        return view('bo.home', compact('title'));
    }
}
