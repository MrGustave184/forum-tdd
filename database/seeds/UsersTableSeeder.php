<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
			// // Method 1
			// 	$users = factory('App\User', 50)->create();
				
			// 	$users->each( function($user) {
			// 		factory('App\Thread')->create(['user_id' => $user->id]);
			// 	});

			// 	\App\Thread::all()->each(function($thread){
			// 		factory('App\Reply', 10)->create([
			// 			'user_id' => $thread->user_id,
			// 			'thread_id' => $thread->id
			// 		]);
			// 	});
			
			factory('App\User', 50)->create();
			factory('App\Thread', 100)->create();
			factory('App\Reply', 500)->create();
    }
}
