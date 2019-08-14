<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
	protected $request; 
	protected $builder;

	protected $filters = [];

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply($builder)
	{
		// Apply our filters to the builder
		// $this->request->by is posible because request('by') exists and laravel use 
		// magic methods to transpose and create the property

		// if($username = $this->request->by) {
		// 	$user = User::where('name', $username)->firstOrFail();

		// 	// filter threads by user id
		// 	return $builder->where('user_id', $user->id);
		// }

		// Refactor
		$this->builder = $builder;

		foreach($this->getFilters() as $filter => $value) {

			// If a method exists for the current filter, apply it
			if(method_exists($this, $filter)) {
				
				// $filter = $this->request->filter; $this->$filter????? $this->request->$filter???????
				$this->$filter($value);
			}
		}

		// if($this->request->has('by')) {
		// 	$username = $this->request->by; // $this->request->by holds the username passed in the url
		// 	$this->by($username); // the by method filters the builder by username
		// }

		return $this->builder;
	}

	public function getFilters()
	{
		// The only method is intercepting our filters with the request data
		return $this->request->only($this->filters);
	}
}