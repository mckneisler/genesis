<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating role users...');

		$user = User::where('name', 'Mark Kneisler')->first();
		$roleId = Code::getCodeId('roles', 'dev');
		$user->roles()->attach($roleId);

		$user = User::where('name', 'Admin Tester')->first();
		$roleId = Code::getCodeId('roles', 'admin');
		$user->roles()->attach($roleId);

		$user = User::where('name', 'Developer Tester')->first();
		$roleId = Code::getCodeId('roles', 'dev');
		$user->roles()->attach($roleId);

		$user = User::where('name', 'Translator Tester')->first();
		$roleId = Code::getCodeId('roles', 'translator');
		$user->roles()->attach($roleId);
    }
}
