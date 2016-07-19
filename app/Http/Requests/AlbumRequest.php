<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AlbumRequest extends Request
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
            'artist_id' => 'required',
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
            'artist_id' => trans_choice('object.artist', 1),
            'name' => trans('object.name')
		];
    }
}
