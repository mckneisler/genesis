<?php

use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    public function run()
	{
		$this->command->info('Creating songs...');
		factory('App\Song', 25)->create()->each(function($song) {
			$rand = rand(0, App\User::count());
			//$this->command->info('  $rand=' . $rand);
			if ($rand > 0) {
				$users = App\User::lists('id')->random($rand);
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
