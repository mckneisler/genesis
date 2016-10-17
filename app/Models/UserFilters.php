<?php

namespace App\Models;

use Illuminate\Http\Request;

class UserFilters extends QueryFilter
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
		$this->builder->where('name', 'like', '%' . $string . '%');
		$this->builder->orWhere('email', 'like', '%' . $string . '%');
		return $this->builder;
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
			case 'name':
				$sorts = [
					'name' => $order,
					'email' => $order
				];
				break;
			case 'email':
				$sorts = [
					'email' => $order,
					'name' => $order
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
