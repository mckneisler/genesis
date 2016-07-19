<?php

use Illuminate\Database\Seeder;

class AlbumsTableSeeder extends Seeder
{
	public function run()
	{
		$this->command->info('Creating albums...');
		factory('App\Album', 5)->create()->each(function($album) {
			$rand = rand(0, App\User::count());
			if ($rand > 0) {
				$users = App\User::lists('id')->random($rand);
				if ($rand == 1) {
					$usersArray = [$users];
				} else {
					$usersArray = $users->toArray();
				}
				$album->users()->sync($usersArray);
			}
		});
	}
}
