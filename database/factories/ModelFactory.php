<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Artist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company
    ];
});

$factory->define(App\Album::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
		'artist_id' => App\Artist::all()->random()->id
    ];
});

$factory->define(App\Song::class, function (Faker\Generator $faker) {
    $album_id = App\Album::all()->random()->id;
	return [
        'name' => $faker->company,
		'album_id' => $album_id,
		'artist_id' => App\Album::find($album_id)->artist_id
    ];
});
