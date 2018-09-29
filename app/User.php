<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * Get the route key name for User.
     *
     * @return string
    */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function avatar()
    {
        return $this->avatar_path ? '/storage/'.$this->avatar_path : '/storage/avatars/default.png';
    }

    /**
     * A user hasMany threads.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * A user hasOne reply.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * A user hasMany activities.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread), 
            Carbon::now()
        );
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }
}
