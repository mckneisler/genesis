<?php

namespace App\Http\Requests\Music;

use App\Http\Requests\Request;
use App\Http\Requests\Request\Music;

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
            'name' => 'required|unique:albums,name,' . $this->id . ',id,artist_id,' . $this->artist_id
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
            'artist_id' => choose(code('objects.artists')->name, 1),
            'name' => choose(code('objects.name')->name, 1)
		];
    }
}
