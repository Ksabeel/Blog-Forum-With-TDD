<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_fatch_their_most_recent_reply()
    {
    	$user = create('App\User');

    	$reply = create('App\Reply', ['user_id' => $user->id]);

    	$this->assertEquals($reply->id, $user->lastReply->id);
    }
}