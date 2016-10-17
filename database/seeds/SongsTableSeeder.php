<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Music\Song;

class SongsTableSeeder extends Seeder
{
    public function run()
	{
		$this->command->info('Creating songs...');
		factory(Song::class, 25)->create()->each(function($song) {
			$rand = rand(0, User::count());
			//$this->command->info('  $rand=' . $rand);
			if ($rand > 0) {
				$users = User::lists('id')->random($rand);
				if ($rand == 1) {
					$usersArray = [$users];
				} else {
					$usersArray = $users->toArray();
				}
				//$this->command->info('  users=' . implode(',', $usersArray));
				$song->users()->sync($usersArray);
			}
		});
    }
}
