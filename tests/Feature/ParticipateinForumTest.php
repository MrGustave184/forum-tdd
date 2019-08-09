<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateinForumTest extends TestCase
{
		use RefreshDatabase;

		protected $thread;

		public function setUp() :void
		{
			parent::setUp();

			// $this->thread = factory('App\Thread')->create();
			$this->thread = create('App\Thread');
		}
		/** @test */
		public function user_may_participate_in_forum_threads()
		{
			$this->withoutExceptionHandling();

			/** Given we have an authenticated user */ 
			// $this->actingAs(factory('App\User')->create());
			$this->actingAs(create('App\User'));


			//$thread = factory('App\Thread')->create();

			/** When the user adds a reply to the thread */ 
			// The make method just returns an instance of the model with its propertys defined through the
			// factory. Whe can emulate the factory()->create() method doing factory()->make()->save()
			// $reply = factory('App\Reply')->make();
			$reply = make('App\Reply');

			// Hit the replies endpoint to submit the new reply
			$this->post($this->thread->path().'/replies', $reply->toArray());

			/** Then their reply should be visible on the page */ 
			// Visit the endpoint to see all the replies of a given thread
			$this->get($this->thread->path())
				->assertSee($reply->body);
		}

		/** @test */
		public function unauthenticated_users_may_not_add_replies()
		{
			// // Disable exception handling for this test is expecting an authentication exception
			// $this->withoutExceptionHandling();

			// // This tests is expecting an authentication exception
			// $this->expectException('Illuminate\Auth\AuthenticationException');

			// // $reply = factory('App\Reply')->make();
			// $reply = make('App\Reply');

			// $this->post($this->thread->path() .'/replies', $reply->toArray());

			// Above code was changed to asserting the redirect instead
			$reply = factory('App\Reply')->make();
			$this->post($this->thread->path().'/replies', $reply->toArray())
				->assertRedirect('/login');
		}

		/** @test */
		public function a_reply_requires_a_body()
		{
			$this->actingAs(factory('App\User')->create());
			
			$reply = factory('App\Reply')->make(['body' => null]);
			
			$this->post($this->thread->path().'/replies', $reply->toArray())
				->assertSessionHasErrors('body');

		}
}
