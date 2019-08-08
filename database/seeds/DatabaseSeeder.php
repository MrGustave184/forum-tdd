<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
			factory('App\User', 50)->create();
			factory('App\Thread', 100)->create();
			factory('App\Reply', 500)->create();
      //$this->call(UsersTableSeeder::class);
    }
}
