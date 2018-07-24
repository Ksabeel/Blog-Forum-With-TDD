<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return auth()->user()->unreadNotifications;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @param  $notificationId
	 * @return \Illuminate\Http\Response
	 */
    public function destroy(User $user, $notificationId)
    {
    	auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
