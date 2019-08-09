<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
		protected $thread;

		public function setup() :void
		{
			parent::setup();

			// $this->thread = factory('App\Thread')->create();
			$this->thread = create('App\Thread');
		}

		/** @test */
		public function a_thread_belongs_to_a_user()
		{
			$this->AssertInstanceOf('App\User', $this->thread->owner);
		}

		/** @test */
		public function a_thread_has_replies()
		{
			$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
		}

		/** @test */
		public function it_can_add_a_reply()
		{
			// Thread_id its left off beacause eloquent will automatically add the thread_id
			$this->thread->addReply([
				'body' => 'foobar',
				'user_id' => 1,
			]);
			
			$this->assertCount(1, $this->thread->replies);
		}

		/** @test */
		public function it_belongs_to_a_channel()
		{
			$this->assertInstanceOf('App\Channel', $this->thread->channel);
		}

		/** @test */
		public function a_thread_can_make_a_string_path()
		{
			// Given we have a thread
			$thread = create('App\Thread');

			// When we output his path with the path() method
			// Then it should be equal to his path
			$this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
		}
}
