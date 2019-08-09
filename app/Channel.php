<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
		// Instruct route model binding for the Channel model to not fetch the model by his id but
		// by his slug instead
		public function getRouteKeyName()
		{
			return 'slug';
		}

		public function threads()
		{
			return $this->hasMany(Thread::class);
		}
}
