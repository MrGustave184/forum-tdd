<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded = [];

	// Add the reply count global query scope
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('replyCount', function($builder) {
			// Add the replies count query to all thread queries
			$builder->withCount('replies');
		});
	}

	/** Return the url path to the thread  */
	public function path()
	{
		return "/threads/{$this->channel->slug}/{$this->id}";
		// return '/threads/'.$this->channel->slug.'/'.$this->id;
	}

	/** A thread has many replies */
	public function replies()
	{
		return $this->hasMany(Reply::class)
			->withCount('favorites');
	}

	/** A thread belongs to a user */
	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function addReply($reply)
	{
		// Eloquent automatically assigns the fields
		$this->replies()->create($reply);
	}

	public function channel()
	{
		return $this->belongsTo(Channel::class);
	}

	// The scope makes that in the function call, the query object is passed automatically to the method
	// $threads = $threads->filter($filters)->get();
	public function scopeFilter($query, $filters)
	{
		// Use the apply method (ThreadFilters) to apply the filters on the currently running query
		return $filters->apply($query);
	}

	// With this, we can call the reply count as a attribute. $thread->replyCount;
	// public function getReplyCountAttribute()
	// {
	// 	return $this->replies()->count();
	// }
}
