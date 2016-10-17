<?php

namespace App\Models\Music;

use Illuminate\Http\Request;

use App\Models\QueryFilter;

class ArtistFilters extends QueryFilter
{
	public function search($string) {
		return $this->builder->where('name', 'like', '%' . $string . '%');
	}

	public function fave($string) {
		return $this->builder->having('users_count', '=', $string);
	}

	public function sort($string) {
		$order = $this->order();
		$reverse = $this->reverse();

		switch ($string) {
			case 'artist':
				$sorts = [
					'artist_name' => $order
				];
				break;
			case 'favorite':
				$sorts = [
					'users_count' => $order,
					'artist_name' => $reverse
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
