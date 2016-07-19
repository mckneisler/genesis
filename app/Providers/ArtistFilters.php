<?php

namespace App;

use Illuminate\Http\Request;

class ArtistFilters extends QueryFilter
{
	public function search($string) {
		return $this->builder->where('name', 'like', '%' . $string . '%');
	}
}
