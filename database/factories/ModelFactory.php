<?php

use App\Models\User;
use App\Models\Music\Artist;
use App\Models\Music\Album;
use App\Models\Music\Song;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Artist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company
    ];
});

$factory->define(Album::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
		'artist_id' => App\Models\Music\Artist::all()->random()->id
    ];
});

$factory->define(Song::class, function (Faker\Generator $faker) {
    $album_id = Album::all()->random()->id;
	return [
        'name' => $faker->company,
		'album_id' => $album_id,
		'artist_id' => Album::find($album_id)->artist_id
    ];
});
