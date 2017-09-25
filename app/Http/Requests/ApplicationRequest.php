<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ApplicationRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        if($this->method() == 'POST'){
            return Auth::user()->can('app.create');
        }
        if($this->method() == 'PUT'){
            return Auth::user()->can('app.update');
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
