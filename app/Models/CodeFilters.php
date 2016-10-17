<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\QueryFilter;

class CodeFilters extends QueryFilter
{
	public function status($status) {
		switch($status) {
			case 'all':
				$this->builder->withTrashed();
				break;
			case 'disabled':
				$this->builder->onlyTrashed();
				break;
		}
		return $this->builder;
	}

	public function search($string) {
		$this->builder->where('code', 'like', '%' . $string . '%');
		$this->builder->orWhere(DB::Raw('IFNULL(IFNULL(loc.name , def.name), codes.code)'), 'like', '%' . $string . '%');
		$this->builder->orWhere(DB::Raw('IFNULL(loc.description , def.description)'), 'like', '%' . $string . '%');
		return $this->builder;
	}

	public function sort($string) {
		$order = $this->order();
		$reverse = $this->reverse();

		switch ($string) {
			case 'code':
				$sorts = [
					'code' => $order
				];
				break;
			case 'name':
				$sorts = [
					'name' => $order
				];
				break;
			case 'desc':
				$sorts = [
					'description' => $order
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
