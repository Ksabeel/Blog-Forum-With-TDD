<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  $channel
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
    public function store($channel, Thread $thread)
    {
    	$thread->subscribe();
    }
}
