<?php

namespace App\Models\Music;

use Illuminate\Http\Request;

use App\Models\QueryFilter;

class AlbumFilters extends QueryFilter
{
	public function search($string) {
		$this->builder->where('artists.name', 'like', '%' . $string . '%');
		$this->builder->orWhere('albums.name', 'like', '%' . $string . '%');
		return $this->builder;
	}

	public function artist_id($string) {
		return $this->builder->where('artist_id', $string);
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
					'artist_name' => $order,
					'album_name' => $order
				];
				break;
			case 'album':
				$sorts = [
					'album_name' => $order,
					'artist_name' => $order
				];
				break;
			case 'favorite':
				$sorts = [
					'users_count' => $order,
					'album_name' => $reverse,
					'artist_name' => $reverse
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
