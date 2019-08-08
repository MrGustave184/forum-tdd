<article style="margin-top:15px;" class="card">

	{{-- created_at and  updated_at are carbon instances --}}
	<h5 class="card-header"> 
		<a href="#">{{ $reply->owner->name }}</a>
			said {{ $reply->created_at->diffForHumans() }}...
	</h5>
	<div class="card-body">
		{{ $reply->body }}
	</div>
</article>