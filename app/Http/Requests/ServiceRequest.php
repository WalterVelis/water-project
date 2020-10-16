<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
                        'required', 'min:5','max:100','unique:services'
                    ],
                    'category_id' =>['required']
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => [
                        'required', 'min:5','max:100', Rule::unique('services')->ignore($this->id_validate),
                    ],
                    'category_id' =>['required']
                ];
            }
            default:break;
        }
    }
    public function attributes()
    {
        if($lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='es'){
            return [
                'name' => 'nombre',
                'category_id' => 'categoría'
            ];
        }else{
            return [
                'budget_section_id' => 'budget section',
                'category_id' => 'category'
            ];
        }
    }
}
