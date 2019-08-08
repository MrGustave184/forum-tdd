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
										
										<form method="POST" action="/threads">
											@csrf
											<div class="form-group">
												<label for="title">Title: </label>
												<input name="title" type="text" class="form-control">
											</div>
											<div class="form-group">
												<label for="body">Body: </label>
												<textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
											</div>
											<button class="btn btn-primary">Create</button>
										</form>
									
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
