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

    /** @test */
    function a_user_can_determine_their_avatar_path()
    {
    	$user = create('App\User'); 

    	$this->assertEquals('/storage/avatars/default.png', $user->avatar_path);

    	$user->avatar_path = 'avatars/me.jpg';

    	$this->assertEquals('/storage/avatars/me.jpg', $user->avatar_path);
    }
}
