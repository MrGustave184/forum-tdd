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
}
