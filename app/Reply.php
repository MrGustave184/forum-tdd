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
}
