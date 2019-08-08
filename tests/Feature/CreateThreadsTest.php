<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
	use RefreshDatabase;

	 /** @test */
	 public function an_authenticated_user_can_create_threads()
	{
			// $this->withoutExceptionHandling();
			
			// Given we have an authenticated user
			// $this->actingAs(factory('App\User')->create());
			$this->actingAs(create('App\User'));

			// When we hit the create thread endpoint providing the neccesary data
			// the raw() method is like make() (doesn't persist the instance) but it doesn't create an object
			//  but a raw data array instead
			// $thread = factory('App\Thread')->raw();	
			// $thread = factory('App\Thread')->make();	
			$thread = make('App\Thread');	
			// dd($thread);
			$this->post('/threads', $thread->toArray());

			// Then when we visit the threads page 
			$this->get($thread->path())

			// We should see the new thread
				->assertSee($thread->title)
				->assertSee($thread->body);
	}

	/** @test */
	public function guests_may_not_create_threads()
	{
		$this->withoutExceptionHandling();
		
		// This tests is expecting an authentication exception
		$this->expectException('Illuminate\Auth\AuthenticationException');

		// Given we are a guest
		// When we try to hit the endpoint to create a new thread
		// Then an exception should be throw at us
		// $thread = factory('App\Thread')->make();
		$thread = make('App\Thread');

		$this->post('/threads', $thread->toArray());
	}

	/** @test */
	public function guests_cannot_see_create_thread_page()
	{
		// This is one way to do the test
		// $this->withoutExceptionHandling();
		// $this->expectException('Illuminate\Auth\AuthenticationException');

		$this->get('/threads/create')
			// This is another one (a better one because it asserts the redirect too)
			->assertRedirect('/login');
	}
}
