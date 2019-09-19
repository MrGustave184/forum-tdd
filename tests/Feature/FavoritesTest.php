<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function guests_cannot_favorite_anything()
	{
		// $this->withoutExceptionHandling();

		$this->post('replies/1/favorites')
			->assertRedirect('/login');
	}

	/** @test */
	 public function an_authenticated_user_can_favorite_any_reply()
	 {
		//  $this->withoutExceptionHandling();

		 $this->actingAs(factory('App\User')->create());

		 $reply = factory('App\Reply')->create();

		 $this->post('replies/' . $reply->id . '/favorites');
		 
		//  dd($reply->favorites);
		// assertDatatabaseHas()

		// assert if the collection has the reply
		$this->assertCount(1, $reply->favorites);
	 }

	 /** @test */
	 public function an_authenticated_user_may_only_favorite_a_reply_once()
	 {
		 $this->withoutExceptionHandling();

		 $this->actingAs(factory('App\User')->create());

		 $reply = factory('App\Reply')->create();

		//  try catch block to tailor the exception message and make it more readable
		 try {
				$this->post('replies/' . $reply->id . '/favorites');
		 		$this->post('replies/' . $reply->id . '/favorites');
		 } catch (\Exception $e) {
				$this->fail('Same record inserted twice');
		 }

		//  dd(\App\Favorite::all()->toArray());
		// assertDatatabaseHas()

		// assert if the collection has the reply
		$this->assertCount(1, $reply->favorites);
	 }
}
