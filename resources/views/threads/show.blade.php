@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
											@foreach($thread->replies as $reply)

											{{-- Show the reply --}}
												@include('threads.reply')
											@endforeach
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
    </div>
</div>
@endsection
