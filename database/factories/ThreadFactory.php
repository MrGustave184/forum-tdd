<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
				// // For the user id, create a user and return the id
				// 'user_id' => function () {
				// 	return factory('App\User')->create()->id;
				// },

				'user_id' => function () {
					// Find a random user in the DB
					$randomUser = \App\User::inRandomOrder()->first();

					// If random user was found, return his id, else create a new user and return his id 
					return $randomUser ? $randomUser->id : factory('App\User')->create()->id;
				},

        'title' => $faker->sentence(),
        'body' => $faker->paragraph,
    ];
});
