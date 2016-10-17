<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeLocale extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
	protected $primaryKey = 'code_locale_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'name',
        'description'
    ];
}
