<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
							
				// 'thread_id' => function () {
				// 	return factory('App\Thread')->create()->id;
				// },

        // 'user_id' => function () {
				// 	return factory('App\User')->create()->id;
				// },

				'user_id' => function () {
					// Find a random user in the DB
					$randomUser = \App\User::inRandomOrder()->first();

					// If random user was found, return his id, else create a new user and return his id 
					return $randomUser ? $randomUser->id : factory('App\User')->create()->id;
				},
				'thread_id' =>  function () {
					// Find a random user in the DB
					$randomThread = \App\Thread::inRandomOrder()->first();

					// If random Thread was found, return his id, else create a new Thread and return his id 
					return $randomThread ? $randomThread->id : factory('App\Thread')->create()->id;
				},

				// TEST WAS FAILING BECAUSE realText() WAS GIVING PROBLEMS WITH assertSee() AND CHARACTER SCAPING
				// 'body' => $faker->realText(200)
				'body' => $faker->paragraph
    ];
});
