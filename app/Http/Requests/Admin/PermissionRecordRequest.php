<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PermissionRecordRequest extends Request
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
            'record_id' => 'required|unique:permission_records,record_id,' .  request()->id . ',id,permission_id,' . request()->permission_id,
            'role_list' => 'required'
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
            'record_id' => choose(code('objects.records')->name, 1),
            'role_list' => choose(code('objects.roles')->name, 2)
		];
    }
}
