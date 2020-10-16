<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required', 'min:3','regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ]*)*)+$/','max:45'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
            'photo' => ['nullable', 'image'],
        ];
    }
    public function attributes()
    {
        if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
            return [
                'name' => 'nombre',
                'email' => 'correo',
                'photo' => 'foto'
            ];
        }
    }
    public function messages(){
    if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
        return [
            'name.regex'=>'El campo nombre no permite caracteres especiales ni números',
       ];
    }else{
        return [
             'name.regex'=>'The name field cannot allow special characters or numbers',
        ];
    }
     }
}