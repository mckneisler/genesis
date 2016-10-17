<?php

namespace App\Http\Utilities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
				'admin' => [
					'id' => 'admin',
					'text' => trans('object.admin'),
					'title' => trans('phrase.adminFunctions'),
					'url' => '#',
					'condition' => Gate::allows('admin_menu-display'),
					'submenu' => [
						'maint' => [
							'id' => 'maint',
							'text' => trans('phrase.maintOff'),
							'title' => trans('phrase.maintOffText'),
							'url' => '/admin/maint/up',
							'condition' => Gate::allows('maint-edit') && app()->isDownForMaintenance()
						],
						'options' => [
							'id' => 'options',
							'text' => choose(code('objects.options')->name, 2),
							'title' => code('actions.edit')->name . ' ' . choose(code('objects.options')->name, 2),
							'url' => '/admin/options/1/edit',
							'condition' => Gate::allows('options-edit')
						],
						'codes' => [
							'id' => 'codes',
							'text' => choose(code('objects.codes')->name, 2),
							'title' => trans('phrase.displayList', ['objects' => choose(code('objects.codes')->name, 2)]),
							'url' => '/admin/types/codes',
							'condition' => Gate::allows('codes-list')
						],
						'translations' => [
							'id' => 'translations',
							'text' => choose(code('objects.translations')->name, 2),
							//'title' => code('actions.edit')->name . ' ' . choose(code('objects.translations')->name, 2),
							'title' => 'Not yet implemented',
							//'url' => '/admin/translations',
							'url' => '#',
							'condition' => Gate::allows('translations-edit')
						],
						'security' => [
							'id' => 'security',
							'text' => trans('object.security'),
							'title' => trans('phrase.security'),
							'url' => '#',
							'condition' => Gate::allows('security_menu-display'),
							'submenu' => [
								'permissions' => [
									'id' => 'permissions',
									'text' => trans_choice('object.permission', 2),
									'title' => trans('phrase.displayList', ['objects' => trans_choice('object.permission', 2)]),
									'url' => '/admin/security/permissions',
									'condition' => Gate::allows('permissions-list')
								],
								'users' => [
									'id' => 'users',
									'text' => trans_choice('object.user', 2),
									'title' => trans('phrase.displayList', ['objects' => trans_choice('object.user', 2)]),
									'url' => '/admin/security/users',
									'condition' => Gate::allows('users-list')
								]
							]
						]
					]
				],
				'user' => [
					'id' => 'user',
					'text' => (Auth::check() ? explode(' ', Auth::user()->name)[0] : ''),
					'title' => '',
					'url' => '#',
					'condition' => Auth::check(),
					'submenu' => [
						'profile' => [
							'id' => 'profile',
							'text' => '<i class="fa fa-user"></i> ' . choose(code('objects.profiles')->name, 1),
							'title' => code('actions.edit')->name . ' ' . choose(code('objects.profiles')->name, 1),
							'url' => '/users/profile/'. (Auth::check() ? Auth::user()->id : 0) . '/edit'
						],
						'options' => [
							'id' => 'options',
							'text' => '<i class="fa fa-cog"></i> ' . choose(code('objects.options')->name, 2),
							'title' => code('actions.edit')->name . ' ' . choose(code('objects.options')->name, 2),
							'url' => '/users/options/'. (Auth::check() ? Auth::user()->id : 0) . '/edit'
						],
						'logout' => [
							'id' => 'logout',
							'text' => '<i class="fa fa-sign-out"></i> ' . trans('action.logout'),
							'title' => trans('phrase.logout', ['appName' => config('custom.appName')]),
							'url' => '/logout'
						]
					]
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
