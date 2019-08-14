@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div>
                <h1 class="jumbotron text-center">Single Thread</h1>
                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
										@if($thread)
												<article class="card">
													<h4 class="card-header"> 
														<a href="#" >{{ $thread->owner->name }}</a> Posted:
														{{ $thread->title }}
													</h4>
													<div class="card-body">
														{{ $thread->body }}
													</div>
												</article>
										@endif
										
										@if($thread->replies)
											@foreach($replies as $reply)

											{{-- Show the reply --}}
												@include('threads.reply')
											@endforeach
											<div style="margin:40px 0;">
												{{ $replies->links() }}
											</div>
											
										@endif

										{{-- Check if user is logged in --}}
										@if(auth()->check())
											<div style="margin-top:25px">
												<div><h2>Write a Reply</h2></div>

												{{-- Reply Form --}}
												<form method="POST" action="{{ $thread->path().'/replies' }}" >
													@csrf
													<div class="form-group">
														<textarea name="body" id="body" class="form-control" rows="8"></textarea>
													</div>
													<button type="submit" class="btn btn-primary">Post</button>
												</form>
											</div>
										@else
											<p>Please <a href="{{ route('register') }}">register</a> or <a href="{{ route('login') }}">sign in</a> to participate in this discuccion</p>
										@endif
										
                </div>
            </div>
				</div>
				<div class="col-md-4">
					<article class="card">
						<div class="card-body">
							{{--
								When you call $thread->replies->count()  with replies as a property, laravel will run the sql
								query and get all the replies and his info, so its a waste of resource. Instead we call the replies as a method to just fetch the count and not all the replies data. This we will extract 
								to a method on the Thread model
								 public function getReplyCountAttribute()
								 {
								 	return $this->replies()->count();
								 }

								 and we call it
								 and currently has {{ $thread->replies()->count() }}
							 --}}

							{{-- 
								We can also use a global query scope. It will automatically apply itself to all $thread queries 
							--}}
							This thread was published {{ $thread->created_at->diffForHumans() }}
							by <a href="#">{{ $thread->owner->name }}</a> and currently has {{ $thread->replies_count }} 
							{{ str_plural('comment', $thread->replies_count)}}.
						</div>
					</article>
				</div>										
    </div>
</div>
@endsection
