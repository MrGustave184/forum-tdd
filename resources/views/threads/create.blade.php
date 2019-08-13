@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h1 class="jumbotron text-center">Create a new Thread</h1>

                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
										
										{{-- Create Thread Form --}}
										{{-- The old() helper function allows us to remember and output old data for errors --}}
										<form method="POST" action="/threads">
											@csrf
											<div class="form-group">
												<label for="channel">Choose a Channel</label>
												<select name="channel_id" id="" class="form-control" required>
													<option value="">Select a channel...</option>

													{{-- The channels variable comes from the appServiceProvider --}}
													@foreach($channels as $channel)

													{{-- Here we check if the old channel id == the current channel id to rememeber the value in cas of an error --}}
													<option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label for="title">Title: </label>
												<input name="title" type="text" class="form-control" value="{{ old('title') }}" required>
											</div>
											<div class="form-group">
												<label for="body">Body: </label>
												<textarea name="body" id="" cols="30" rows="10" class="form-control" required>{{ old('body') }}</textarea>
											</div>
											<button class="btn btn-primary">Create</button>
										</form>
									
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
