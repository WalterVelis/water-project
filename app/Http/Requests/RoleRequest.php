<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                        'required', 'min:3', Rule::unique((new Role)->getTable())->ignore($this->route()->role->id ?? null)
                    ],
                    'description' => [
                        'nullable', 'min:5'
                    ]
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => [
                        'required', 'min:3', Rule::unique((new Role)->getTable())->ignore($this->route()->role->id ?? null)
                    ],
                    'description' => [
                        'nullable', 'min:5'
                    ]
                ];
            }
            default:break;
        }
    }
}