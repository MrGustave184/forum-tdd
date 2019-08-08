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

			$this->thread = factory('App\Thread')->create();
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
}
