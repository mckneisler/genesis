<?php

use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
	public function run()
	{
		$this->command->info('Creating artists...');
		factory('App\Artist', 5)->create()->each(function($artist) {
			$rand = rand(0, App\User::count());
			if ($rand > 0) {
				$users = App\User::lists('id')->random($rand);
				if ($rand == 1) {
					$usersArray = [$users];
				} else {
					$usersArray = $users->toArray();
				}
				$artist->users()->sync($usersArray);
			}
		});
	}
}
