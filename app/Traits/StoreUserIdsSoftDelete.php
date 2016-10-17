<?php

namespace App\Traits;

use Auth;

trait StoreUserIdsSoftDelete
{

    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {
			if (Auth::user()) {
				$user_id = Auth::user()->id;
			} else {
				$user_id = 1;
			}
            $model->created_by = $user_id;
            $model->updated_by = $user_id;
        });

        static::updating(function ($model) {
			if (Auth::user()) {
				$user_id = Auth::user()->id;
			} else {
				$user_id = 1;
			}
            $model->updated_by = $user_id;
        });

        static::deleting(function ($model) {
			if (Auth::user()) {
				$user_id = Auth::user()->id;
			} else {
				$user_id = 1;
			}
            $model->updated_by = $user_id;
            $model->deleted_by = $user_id;
			$model->save();
        });

        static::restoring(function ($model) {
			if (Auth::user()) {
				$user_id = Auth::user()->id;
			} else {
				$user_id = 1;
			}
            $model->updated_by = $user_id;
            $model->deleted_by = null;
        });
    }
}
