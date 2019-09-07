<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorite;

class FavoritesController extends Controller
{
		public function __construct()
		{
			$this->middleware('auth');
		} 

		public function store(Reply $reply)
		{
			// $this->withoutExceptionHandling();

			// // Using the DB facade (we dont have a model yet)
			// return \DB::table('favorites')->insert([
			// 	'user_id' => auth()->id(),
			// 	'favorited_id' => $reply->id,
			// 	'favorited_type' => get_class($reply)
			// ]);

			// // Using active record
			// Favorite::create([
			// 	'user_id' => auth()->id(),
			// 	'favorited_id' => $reply->id,
			// 	'favorited_type' => get_class($reply)
			// ]);

			// Using the eloquent polymorphic relationship
			// For we have the relationshiop defined, favorited_id and favorited_type will be assigned automatically
			return $reply->favorite();
		}
}
