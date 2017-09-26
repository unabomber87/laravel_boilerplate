<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingUpgradeRequest;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;

class SettingController extends Controller{

    private $title;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->title = 'Setting';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(!Auth::user()->can('setting.list'))
            return abort(401);
        $settings = Setting::all()->pluck('value', 'name');
        $title = $this->title;
        return view('bo.settings.index', compact('title', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!Auth::user()->can('setting.create'))
            return abort(401);
        $title = $this->title;
        return view('bo.settings.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    public function upgrade(SettingUpgradeRequest $request){

        $name = Setting::where('name', '=', 'name')->first();
        $lang = Setting::where('name', '=', 'lang')->first();
        $logo = Setting::where('name', '=', 'logo')->first();
        $icon = Setting::where('name', '=', 'icon')->first();

        // update name
        $name->value = $request->name;
        $name->save();

        // update lang
        $lang->value = $request->lang;
        $lang->save();

        // upload logo
        if($request->hasFile('logo')){
          $image = $request->file('logo');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/site');
            $image->move($destinationPath, $input['imagename']);
            $logo->value = $input['imagename'];
            $logo->save();  
        }

        // upload icon
        if($request->hasFile('icon')){
            $image = $request->file('icon');
            $input['iconname'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/site');
            $image->move($destinationPath, $input['iconname']);
            $icon->value = $input['iconname'];
            $icon->save();   
        }
        return redirect('/settings');
        //dd($request->all());
    }
}
