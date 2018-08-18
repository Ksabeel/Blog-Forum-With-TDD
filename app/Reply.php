<?php

namespace App;

use Carbon\Carbon;
use App\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;
    
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
    */
	protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];
	
    /**
     * Boot the model.
    */
    public static function boot()
    {
        parent::boot();

        static::created( function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted( function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * A reply has an owner.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A reply belongs to a thread.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
    
    public function mentionedUsers()
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);
        
        return $matches[1];
    }

    /**
     * Get string path for the reply.
     *
     * @return string
    */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
