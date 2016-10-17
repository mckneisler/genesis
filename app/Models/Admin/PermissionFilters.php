<?php

namespace App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\QueryFilter;

class PermissionFilters extends QueryFilter
{
	public function search($string) {
		$this->builder->orWhere(DB::Raw('IFNULL(IFNULL(object_loc.name , object_def.name), object.code)'), 'like', '%' . $string . '%');
		$this->builder->orWhere(DB::Raw('IFNULL(IFNULL(action_loc.name , action_def.name), action.code)'), 'like', '%' . $string . '%');
		return $this->builder;
	}

	public function object($string) {
		return $this->builder->where('object.code', $string);
	}

	public function action($string) {
		return $this->builder->where('action.code', $string);
	}

	public function role($string) {
		$this->builder->whereHas('roles', function($query) use ($string) {
			$query->where('code', $string);
		});
		return $this->builder;
	}

	public function sort($string) {
		$order = $this->order();
		$reverse = $this->reverse();

		switch ($string) {
			case 'object':
				$sorts = [
					'object_name' => $order,
					'action_name' => $order
				];
				break;
			case 'action':
				$sorts = [
					'action_name' => $order,
					'object_name' => $order
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
