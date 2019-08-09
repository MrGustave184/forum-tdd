<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
	use RefreshDatabase;

	// Authenticate the user, creates a thread and makes the post request to persist it 
	public function publishThread($overrides = [])
	{
		$user = $this->actingAs(factory('App\User')->create());

		$thread = factory('App\Thread')->make($overrides);

		// Return the response to enable a fluid interface
		return $this->post('/threads', $thread->toArray());
	}

	 /** @test */
	 public function an_authenticated_user_can_create_threads()
	{
			$this->withoutExceptionHandling();
			
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
			$response = $this->post('/threads', $thread->toArray());
			// dd($response->headers->get('Location'));

			// Then when we visit the threads page 
			// We cant use $thread->path for the request because we are making a thread with
			//  the factory (make), not persisting it (create), so it doesn't have an id and it 
			// can't fullfil the path() format we defined (/threads/channel/id).
			// Thats why we use the response and get the path from there
			$this->get($response->headers->get('Location'))

			// We should see the new thread
				->assertSee($thread->title)
				->assertSee($thread->body);
	}

	// Both of the following tests are doing the same job, so we can merge them together in this one single test

	/** @test */
	public function guest_users_cannot_create_threads()
	{
		$this->post('/threads')
			->assertRedirect('/login');

		$this->get('/threads/create')
			->assertRedirect('/login');
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

	/** @test */
	public function a_thread_requires_a_title()
	{
		$this->publishThread(['title' => null])

		// Laravel throws an errors variable to the session, we gonna check if that
		// variable has a 'title' key when we do not provide a title to our thread
		//  wich indicates that our test is correct
			->assertSessionHasErrors('title');
	}

	/** @test */
	public function a_thread_requires_a_body()
	{
		$this->publishThread(['body' => null])
			->assertSessionHasErrors('body');
	}

	/** @test */
	public function a_thread_requires_a_valid_channel()
	{
		factory('App\Channel', 2)->create();

		// Validate channel_id has a value
		$this->publishThread(['channel_id' => null])
			->assertSessionHasErrors('channel_id');

		// Validate channel id exists in the channels table
		$this->publishThread(['channel_id' => 999])
			->assertSessionHasErrors('channel_id');
	}
}
	