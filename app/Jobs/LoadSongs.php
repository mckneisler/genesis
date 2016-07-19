<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Artist;
use App\Album;
use App\Song;

class LoadSongs extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	protected $filepath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->filepath = public_path(). "/upload/" . $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dump($this->filepath);
		$file = file_get_contents($this->filepath, 'r');
		$i = 0;
		define ('SONG', 0);
		define ('ARTIST', 1);
		define ('ALBUM', 3);
		define ('GENRE', 5);
		define ('RATING', 25);

		if (!User::all()->count()) {
			User::create([
				'name' => 'Mark Kneisler',
				'email' => 'mckneisler@hotmail.com',
				'password' => bcrypt('secret')
			]);
		}

		if (!Artist::all()->count()) {
			Artist::create([
				'name' => 'Various Artists'
			]);
		}

		$songs = explode("\r", $file);
		foreach ($songs as $i => $song) {
			$fields = explode("\t", $song);
dump($fields);
			if ($i > 0 && $fields[SONG] && $fields[ARTIST] && $fields[ALBUM] && !in_array($fields[GENRE], ["Comedy", "Voice Memo"])) {
				$values = [
					'name' => $fields[ARTIST]
				];
				$artist = Artist::updateOrCreate($values, $values);

				$album = Album::where('name', $fields[ALBUM])->first();
				if (is_null($album)) {
					$album = Album::create(['name' => $fields[ALBUM], 'artist_id' => $artist->id]);
				} else if ($album->artist_id != $artist->id && $album->artist_id != 1) {
					$album->artist_id = 1;
					$album->update();
				}

				$values = [
					'name' => $fields[SONG],
					'album_id' => $album->id,
					'artist_id' => $artist->id
				];
				$song = Song::updateOrCreate($values, $values);
				if (array_key_exists(RATING, $fields) && $fields[RATING] == 100 && !$song->users->contains(1)) {
					$song->users()->attach(1);
				}
			}
		}
    }
}
