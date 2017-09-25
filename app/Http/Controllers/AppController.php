<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\App;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\ApplicationRequest;

class AppController extends Controller{

    private $title;
    private $attribs;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->title = 'Application';
        $this->attribs = ['list', 'create', 'update', 'delete'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(!Auth::user()->can('app.list'))
            return redirect()->back();
        $apps = App::all();
        $title = $this->title;
        $addurl = route('apps.create');
        return view('bo.apps.index', compact('title', 'apps', 'addurl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!Auth::user()->can('role.create'))
            return redirect()->back();
        $title = $this->title;
        return view('bo.apps.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request){
        $app = App::create(['name' => $request->name]);
        foreach ($this->attribs as $attrib) {
          Permission::create(['name' => $request->name.'.'.$attrib]);  
        }
        return redirect('/apps');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if(!Auth::user()->can('app.update'))
            return redirect()->back();
        $title = $this->title;
        $app = App::find($id);
        if($app)
            return view('bo.apps.edit', compact('title', 'app'));
        else
            return redirect('/apps');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, $id){
        $app = App::find($id);

        $permissions = Permission::where('name', 'like', '%' . $app->name . '%')->get();
        
        $i = 0;
        foreach($permissions as $perm){
            $perm->name = $request->name.'.'.$this->attribs[$i];
            $perm->save();
            $i++;
        }

        $app->name = $request->name;
        $app->update();
        return redirect('/apps');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if(!Auth::user()->can('app.delete'))
            return redirect()->back();
        $app = App::find($id);
        $permissions = Permission::where('name', 'like', '%' . $app->name . '%')->get();
        
        foreach($permissions as $perm){
            $perm->delete();
        }

        $app->delete();
        return redirect('/apps');
    }
}
