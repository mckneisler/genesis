<?php

namespace App\Http\Utilities;

use Illuminate\Support\Facades\Auth;

class Menu {

	private static $menu;

	public static function get($key = null)
	{
		$menu = [
			'left' => [
				'music' => [
					'id' => 'music',
					'text' => trans('object.music'),
					'title' => trans('phrase.musicDisplay'),
					'url' => '#',
					'submenu' => [
						'artists' => [
							'id' => 'artists',
							'text' => trans_choice('object.artist', 2),
							'title' => trans('phrase.displayList', ['objects' => trans_choice('object.artist', 2)]),
							'url' => '/music/artists'
						],
						'albums' => [
							'id' => 'albums',
							'text' => trans_choice('object.album', 2),
							'title' => trans('phrase.displayList', ['objects' => trans_choice('object.album', 2)]),
							'url' => '/music/albums'
						],
						'songs' => [
							'id' => 'songs',
							'text' => trans_choice('object.song', 2),
							'title' => trans('phrase.displayList', ['objects' => trans_choice('object.song', 2)]),
							'url' => '/music/songs'
						]
					]
				]
			],
			'right' => [
				'logout' => [
					'id' => 'logout',
					'text' => '<i class="fa fa-btn fa-sign-out"></i> ' . trans('action.logout'),
					'title' => trans('phrase.logout', ['appName' => config('custom.appName')]),
					'url' => '/logout',
					'condition' => Auth::check()
				],
				'login' => [
					'id' => 'login',
					'text' => trans('action.login'),
					'title' => trans('phrase.login', ['appName' => config('custom.appName')]),
					'url' => '/login',
					'condition' => Auth::guest()
				],
				'register' => [
					'id' => 'register',
					'text' => trans('action.register'),
					'title' => trans('phrase.register'),
					'url' => '/register',
					'condition' => Auth::guest()
				]
			]
		];

		self::$menu = $menu;

		if ($key != null) {
			return self::$menu[$key];
		}

		return self::$menu;
	}
}
