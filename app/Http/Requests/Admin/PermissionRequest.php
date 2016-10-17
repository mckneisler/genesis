<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PermissionRequest extends Request
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
            'object_id' => 'required|unique:permissions,object_id,' .  request()->id . ',id,action_id,' . request()->action_id,
            'action_id' => 'required',
            'role_list' => 'required'
        ];
    }

	public function messages()
	{
		return [
			'object_id.unique' => trans('validation.unique', [
				'attribute' => choose(code('objects.objects')->name, 1)
					. '-' . choose(code('objects.actions')->name, 1)
					. ' ' . strtolower(choose(code('objects.combination')->name, 1))
			])
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
            'object_id' => choose(code('objects.objects')->name, 1),
            'action_id' => choose(code('objects.actions')->name, 1),
            'role_list' => choose(code('objects.roles')->name, 2)
		];
    }
}
