****************************************
Tinker
****************************************
Populate the db using tinker:
	create all the factories then:
		 php artisan tinker $threads = factory('App\Thread', 50)->create()
	ThredFactory automatically creates 50 users, so now we only need to create some replys for each thread:
	<?php
		$threads->each(function($thread) {
			// Here we set the thread_id to the id of the current thread being iterated
			// so the factory doesn't create more threads
			factory('App\Reply', 10)->create([
				'thread_id' => $thread->id;
			]);
		});
	?>

****************************************
Using Test Database
****************************************
in php unit.xml, you can use the .env global variables to define a test database



****************************************
Handler.php and exceptions
****************************************
By default, laravel doesn't throw an exception when its just submiting a post request to an
endpoint that doesn't exists, so we can go to Handler.php and in the render method, add:
<?php if(app()->environment() === 'testing') throw $exception; ?>