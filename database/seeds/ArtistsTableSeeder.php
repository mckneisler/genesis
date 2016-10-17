<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Music\Artist;

class ArtistsTableSeeder extends Seeder
{
	public function run()
	{
		$this->command->info('Creating artists...');
		factory(Artist::class, 5)->create()->each(function($artist) {
			$rand = rand(0, User::count());
			if ($rand > 0) {
				$users = User::lists('id')->random($rand);
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
