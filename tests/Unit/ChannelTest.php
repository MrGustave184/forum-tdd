<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
	 /** @test */
	 public function it_has_many_threads_associated()
	 {
		//  // One approach: We check if in fact, $channel->threads returns a collection of threads
		//  $channel = factory('App\Channel')->create();
		//  $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $channel->threads);

		//  Another approach
		$channel = factory('App\Channel')->create();
		$thread = factory('App\Thread')->create(['channel_id' => $channel->id]);

		$this->assertTrue($channel->threads->contains($thread));
	 }
}
