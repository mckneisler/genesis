<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
		$rules = [
            'name' => 'required|max:255|unique:users,name,' .  $this->id . ',id',
            'email' => 'required|email|max:255|unique:users,email,' .  $this->id . ',id'
        ];

		switch ($this->method) {
			case 'POST':
				$rules = array_add($rules, 'password', 'required|min:6|confirmed');
				break;
			case 'PATCH':
				$rules = array_add($rules, 'password', 'min:6|confirmed');
				break;
		}
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => choose(code('objects.name')->name, 1),
            'email' => choose(code('objects.email')->name, 1),
            'password' => choose(code('objects.password')->name, 1)
		];
    }
}
