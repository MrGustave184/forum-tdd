@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h1 class="jumbotron text-center">Forum Threads</h1>

                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
										
										@if($threads)
											@foreach($threads as $thread)
												<article class="card">
													
													<div class="level card-header">
														<h4 class="flex"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h4>
														<strong>
															{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count)}} 
														</strong>
													</div>

													<div class="card-body">
														{{ $thread->body }}
													</div>
													
												
												</article>
											@endforeach
										@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
