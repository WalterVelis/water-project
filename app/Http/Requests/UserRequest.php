<?php

namespace App\Http\Requests;

use App\Role;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch($this->method()){
            case 'POST':
            {
                return [
                    'name' => [
                        'required', 'min:5','regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ]*)*)+$/','max:45'
                    ],
                    'email' => [
                        'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
                    ],
                    'role_id' => [
                        'required', 'exists:'.(new Role)->getTable().',id'
                    ]/* ,
                    'password' => [
                        $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6','regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'
                    ] */
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => [
                        'required', 'min:5','regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ]*)*)+$/','max:45'
                    ],
                    'email' => [
                        'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
                    ],
                    'role_id' => [
                        'required', 'exists:'.(new Role)->getTable().',id'
                    ]/* ,
                    'password' => [
                        $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6','regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'
                    ] */
                ];
            }
            default:break;
        }

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
                'name' => 'nombre',
                'email' => 'correo',
                'role_id' => 'rol',
                'password' => 'contraseña'
            ];
        }else{
            return [
                'role_id' => 'role',
            ];
        }
    }

    public function messages(){
        if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
            return [
                'name.regex'=>'El campo nombre no permite caracteres especiales ni números',
                'password.regex'=>'El campo contraseña debe incluir minúsculas, mayúsculas y al menos un número',
           ];
        }else{
            return [
                 'name.regex'=>'The name field cannot allow special characters or numbers',
                 'password.regex'=>'The password field must include capital letters and at least one number',
            ];
        }
     }
}