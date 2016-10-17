<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CodeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'code' => 'required|unique:codes,code,' .  $this->id . ',id,parent_code_id,' . $this->parent_code_id,
			'name' => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'code' => choose(code('objects.codes')->name, 1),
            'name' => choose(code('objects.name')->name, 1),
            'description' => choose(code('objects.description')->name, 1)
		];
    }
}
