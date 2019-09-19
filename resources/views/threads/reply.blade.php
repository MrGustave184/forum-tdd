<article style="margin-top:15px;" class="card">
	<div class="card-header">
		<div class="row">
			<div class="py-1 col-8">
			{{-- The direct reference to the owner relationship in the reply model is giving us n + 1,
				so we gonna eager load the owner 
				<a href="#" >{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}... 
			--}}
				<h5><a href="#" >{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...</h5>
			</div>
			<div class="col-4 text-right">
				<form action="/replies/{{ $reply->id}}/favorites" method="POST">
					@csrf
					<button class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : ''}}>
						{{-- 
							This is giving us a lot of queries because we are not eager loading the favorites count, but refering directly to the relationship
							{{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count())}} 
						--}}

						{{-- 
							Favorites_count comes from the eager loading withCount(favorites), this will automatically
							create the favorites_count property
						--}}
							{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count)}} 
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="card-body">
		{{ $reply->body }}
	</div>
</article>