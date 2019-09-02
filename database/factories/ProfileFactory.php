<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement($array = ['Male', 'Female']),
        'date_of_birth' => $faker->dateTime($max = 'now'),
        'contact_email' => $faker->unique()->email,
        'avatar' => $faker->imageUrl(400, 400),
        'facebook_profile' => 'https://www.facebook.com/'.$faker->word,
        'twitter_profile' => 'https://twitter.com/'.$faker->word,
        'instagram_profile' => 'https://instagram.com/'.$faker->word,
    ];
});
