<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = [
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

        $this->call(UsersTableSeeder::class);
        $this->call(ArtistsTableSeeder::class);
        $this->call(AlbumsTableSeeder::class);
        $this->call(SongsTableSeeder::class);
/*
*/
    }
}
