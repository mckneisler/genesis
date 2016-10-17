<?php

namespace App\Models\Music;

use Illuminate\Http\Request;

use App\Models\QueryFilter;

class SongFilters extends QueryFilter
{
	public function search($string) {
		//return $this->builder->where(function($query) use($string) {
		//	$query->whereRaw('LOWER(`artists`.`name`) like ?', ['%' . strtolower($string) . '%'])
		//	->orWhereRaw('LOWER(`albums`.`name`) like ?', ['%' . strtolower($string) . '%'])
		//	->orWhereRaw('LOWER(`songs`.`name`) like ?', ['%' . strtolower($string) . '%']);
		//});
		$this->builder->where('artists.name', 'like', '%' . $string . '%');
		$this->builder->orWhere('albums.name', 'like', '%' . $string . '%');
		$this->builder->orWhere('songs.name', 'like', '%' . $string . '%');
		return $this->builder;
	}

	public function album_id($string) {
		return $this->builder->where('songs.album_id', $string);
	}

	public function artist_id($string) {
		return $this->builder->where('songs.artist_id', $string);
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
					'album_name' => $order,
					'song_name' => $order
				];
				break;
			case 'album':
				$sorts = [
					'album_name' => $order,
					'song_name' => $order,
					'artist_name' => $order
				];
				break;
			case 'song':
				$sorts = [
					'song_name' => $order,
					'artist_name' => $order,
					'album_name' => $order
				];
				break;
			case 'favorite':
				$sorts = [
					'users_count' => $order,
					'artist_name' => $reverse,
					'album_name' => $reverse,
					'song_name' => $reverse
				];
				break;
		}

		return $this->applySorts($sorts);
	}
}
