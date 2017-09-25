<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RoleRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        if($this->method() == 'POST'){
            return Auth::user()->can('role.create');
        }
        if($this->method() == 'PUT'){
            return Auth::user()->can('role.update');
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'name' => 'required'
        ];
    }
}
