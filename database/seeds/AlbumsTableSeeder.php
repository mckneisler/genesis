<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Music\Album;

class AlbumsTableSeeder extends Seeder
{
	public function run()
	{
		$this->command->info('Creating albums...');
		factory(Album::class, 5)->create()->each(function($album) {
			$rand = rand(0, User::count());
			if ($rand > 0) {
				$users = User::lists('id')->random($rand);
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
