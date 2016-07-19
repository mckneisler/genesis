<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
	protected $request;

	protected $builder;

	/**
	 * QueryFilter constructor
	 *
	 * @param $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function applySorts($sorts)
	{
		foreach ($sorts as $field => $direction) {
			$this->builder->orderBy($field, $direction);
		}
		return $this->builder;
	}

	public function order()
	{
		if (request()->has('order')) {
			return request()->order;
		}
		return 'asc';
	}

	public function reverse()
	{
		if ($this->order() == 'asc') {
			return 'desc';
		}
		return 'asc';
	}
	/**
	 * Applies the filters
	 *
	 * @param $builder
	 */
	public function apply(Builder $builder)
	{
		$this->builder = $builder;

		foreach ($this->filters() as $name => $value) {
			if (method_exists($this, $name) && $value !== "") {
				call_user_func_array([$this, $name], [$value]);
			}
		}

		return $this->builder;
	}

	public function filters() {
		return $this->request->all();
	}
}
