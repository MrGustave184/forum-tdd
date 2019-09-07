<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
		protected $fillable = ['user_id', 'body'];

		public function owner()
		{
			// If the method name is not the same as the FK (ex. for user, user_id), we can pass
			// a second parameter with the name of the FK that defines the relationship			
			return $this->belongsTo(User::class, 'user_id');
		}

		public function favorites()
		{
			// The second argument is the prefix we gonna use. So every favoritable model
			// must have an prefix_id and prefix_type, so in this case it will be:
			// favorited_id and favorited_type
			return $this->morphMany(Favorite::class, 'favorited');
		}

		// Favorite the reply
		public function favorite()
		{
			// Using the eloquent polymorphic relationship
			// For we have the relationshiop defined, favorited_id and favorited_type will be assigned automatically
			$attributes = ['user_id' => auth()->id()];

			// If the user hasn't already favorited the reply, then favorite it
			if (! $this->favorites()->where($attributes)->exists()) {
				return $this->favorites()->create($attributes);
			}
		}
}
