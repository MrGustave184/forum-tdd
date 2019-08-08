<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded = [];

	/** Return the url path to the thread  */
	public function path()
	{
		return '/threads/' . $this->id;
	}

	/** A thread has many replies */
	public function replies()
	{
		return $this->hasMany(Reply::class);
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
}
