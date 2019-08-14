<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	 public function an_authenticated_user_can_favorite_any_reply()
	 {
		 $this->withoutExceptionHandling();
	 
		 $reply = factory('App\Reply')->create();

		 $this->post('replies/' . $reply->id . '/favorites')
		 	->assertCount(1, $reply->favorites);
	 }
}
