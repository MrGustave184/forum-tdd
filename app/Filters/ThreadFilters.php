<?php
namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
	protected $filters = ['by', 'popular'];
	
	// Filter 'by' (username)
	protected function by($username)
	{
		$user = User::where('name', $username)->firstOrFail();
		
		return $this->builder->where('user_id', $user->id);
	}

	// Filter the query according to most popular threads
	protected function popular()
	{
		// Clear 'orders' in the query to be able to order by replies
		$this->builder->getQuery()->orders = [];

		return $this->builder->orderBy('replies_count', 'desc');
	}
}