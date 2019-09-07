<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
	use RefreshDatabase;

	protected $thread;
	

	public function setUp() :void
	{
		// All tests extends TestCase, so we have to call the parent setUp() 
		parent::setUp();

		$this->thread = factory('App\Thread')->create();
	}
	
	/** @test */
	public function a_user_can_browse_all_threads()
	{
		$this->withoutExceptionHandling();
		
		// Get request to /threads endpoint
		$this->get('/threads')
			->assertSee($this->thread->title);
	}

	/** @test */
	public function a_user_can_read_single_thread()
	{
			$this->get($this->thread->path())
				->assertSee($this->thread->title);
	}

	/** @test */
	public function a_user_can_read_replies_associated_with_a_thread()
	{
		// Given we have a thread with replies
			// Create reply
			$reply = factory('App\Reply')->create([
				 'thread_id' => $this->thread->id,
			]);

		// When we display a single thread
		$this->get($this->thread->path())

		// Then we should see those replies
				->assertSee($reply->body);
	}

	/** @test */
	public function a_user_can_filter_threads_by_channel()
	{
		$this->withoutExceptionHandling();
		
		$channel = factory('App\Channel')->create();
		$threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);
		$threadNotInChannel = factory('App\Thread')->create();

		$this->get('/threads/' . $channel->slug)
			->assertSee($threadInChannel->tittle)
			->assertDontSee($threadNotInChannel->title);
	}
		
	/** @test */
	public function a_user_can_filter_threads_by_username()
	{
		$jhon = factory('App\User')->create(['name' => 'JhonDoe']);
		$jane = factory('App\User')->create();
		
		$this->actingAs($jhon);
		$threadByJhon = factory('App\Thread')->create(['user_id' => auth()->id()]);
		
		$this->actingAs($jane);
		$threadByJane = factory('App\Thread')->create(['user_id' => auth()->id()]);

		$this->get('/threads?by=JhonDoe')
			->assertSee($threadByJhon->title)
			->assertDontSee($threadByJane->title);
	}

	/** @test */
	public function a_user_can_filter_threads_by_popularity()
	{
		// Given we have 3 threads, with 2, 3 and 0 replies respectively
		$threadWithTwoReplies = factory('App\Thread')->create();
		factory('App\Reply', 2)->create(['thread_id' => $threadWithTwoReplies->id]);

		$threadWithThreeReplies = factory('App\Thread')->create();
		factory('App\Reply', 3)->create(['thread_id' => $threadWithThreeReplies->id]);

		$threadWithNoReplies = $this->thread;
		
		// When i filter all threads by popularity
		$response = $this->getJson('threads?popular=1')->json(); // This returns a collection of threads

		// Then they should be returned from most replies to least

		// extract the replies count value for each thread and assert they are arranged in order
		// by the reply count
		$this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
	}
}