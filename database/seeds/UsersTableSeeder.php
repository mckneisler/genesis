<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder {
	public function run() {
		$this->command->info('Creating users...');
		User::create([
			'name' => 'Mark Kneisler',
			'email' => 'mckneisler@hotmail.com',
			'password' => bcrypt('secret')
		]);
		User::create([
			'name' => 'Admin Tester',
			'email' => 'admin@chickenmadness.ro',
			'password' => bcrypt('secret')
		]);
		User::create([
			'name' => 'Developer Tester',
			'email' => 'dev@chickenmadness.ro',
			'password' => bcrypt('secret')
		]);
		User::create([
			'name' => 'Translator Tester',
			'email' => 'translator@chickenmadness.ro',
			'password' => bcrypt('secret')
		]);
		factory(User::class, 5)->create();
	}
}
