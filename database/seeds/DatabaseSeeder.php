<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = [
		'option_user_values',
		'permission_record_role',
		'permission_records',
		'permission_role',
		'role_user',
		'permissions',
		'code_locales',
		'codes',
		'song_user_favorite',
		'songs',
		'album_user_favorite',
		'albums',
		'artist_user_favorite',
		'artists',
		'users'
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') {
			exit();
		}

		Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		foreach ($this->toTruncate as $table) {
			$this->command->info('Deleting ' . $table . '...');
			DB::table($table)->truncate();
		}
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		User::create([
			'name' => 'System',
			'email' => 'system@chickenmadness.ro',
			'password' => bcrypt('secret'),
			'created_by' => 1,
			'updated_by' => 1
		]);
		Auth::loginUsingId(1);

        $this->call(UsersTableSeeder::class);

        $this->call(ArtistsTableSeeder::class);
        $this->call(AlbumsTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(CodesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(PermissionRecordsTableSeeder::class);
        $this->call(PermissionRecordRoleTableSeeder::class);
        $this->call(OptionUserValuesTableSeeder::class);
    }
}
