<?php

namespace App;

trait Favoritable
{
	/**
     * A reply can be favorited.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite the current reply.
     *
     * @return Model
    */
    public function favorite()
    {
    	$attributes = ['user_id' => auth()->id()];

    	if (! $this->favorites()->where($attributes)->exists()) {
	    	return $this->favorites()->create($attributes);
    	}
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return Boolean
    */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}