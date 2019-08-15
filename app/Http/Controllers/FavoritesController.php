<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class FavoritesController extends Controller
{
		public function store(Reply $reply)
		{
			return \DB::table('favorites')->insert([
				'user_id' => auth()->id(),
				'favorited_id' => $reply->id,
				'favorited_type' => get_class($reply)
			]);
		}
}
