<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
		/** @test */
    public function a_reply_belongs_to_a_user()
    {
			$reply = factory('App\Reply')->create();

			// Make sure the reply has an owner 
			$this->AssertInstanceOf('App\User', $reply->owner);
    }
}
