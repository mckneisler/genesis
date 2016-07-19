<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	public function run() {
		$this->command->info('Creating users...');
		App\User::create([
			'name' => 'Mark Kneisler',
			'email' => 'mckneisler@hotmail.com',
			'password' => bcrypt('secret')
		]);
		factory('App\User', 5)->create();
	}
}
