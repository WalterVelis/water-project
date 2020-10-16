<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required', 'min:6', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password','regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'password_confirmation' => ['required', 'min:6'],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
            return [
                'old_password' => 'contraseña actual',
                'password' =>    'contraseña',

            ];

        }else{
            return [
                'old_password' => __('current password'),     
                ];
        }
    }
    public function messages(){
        if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
            return [
                'password.regex'=>'El campo contraseña debe incluir minúsculas, mayúsculas y al menos un número',
           ];
        }else{
            return [
                 'password.regex'=>'The password field must include capital letters and at least one number',
            ];
        }
     }
}