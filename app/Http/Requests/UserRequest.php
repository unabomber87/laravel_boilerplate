<?php

namespace App\Http\Requests;

use App\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        if($this->method() == 'POST'){
            return Auth::user()->can('user.create');
        }
        if($this->method() == 'PUT'){
            return Auth::user()->can('user.update');
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        $user = User::find($this->user);
        if($user){
            return [
                'name' => 'required',
                'email'      => 'required|email|unique:users,email,'.$user->id,
                'password'   => 'confirmed',
            ];   
        }
        
        return [
            'name' => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed',
        ];
    }
}
