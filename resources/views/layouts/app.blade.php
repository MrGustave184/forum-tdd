<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<style>
			body {
				padding-bottom: 100px;
			}

			.level {
				display: flex;
				align-items: center;
			}

			.flex { 
				/* The element takes all available space in the row */
				flex: 1 
			}
			
		</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
								</a>	

                {{-- All Threads Dropdown --}}
								<div class="dropdown navbar-brand">
									<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Threads
									</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="/threads">All Threads</a>
										<a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>
										
										@if(auth()->check())
											<a class="dropdown-item" href="/threads?by={{ auth()->user()->name }}">My Threads</a>
										@endif
									</div>
								</div>
								{{-- /All Threads Dropdown --}}

								@if(auth()->check())
									<a class="navbar-brand" href="{{ url('/threads/create') }}">
											New Thread
									</a>
								@endif
								
								{{-- Categories Dropdown --}}
								<div class="dropdown navbar-brand">
									<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Categories
									</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										@foreach($channels as $channel)
											<a class="dropdown-item" href="/threads/{{$channel->slug}}">{{ $channel->name }}</a>
										@endforeach
									</div>
								</div>
								{{-- /Categories Dropdown --}}

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
				</nav>
				
				{{-- Main Content --}}
        <main class="py-4">

					{{-- Display errors --}}
					@if(count($errors))
						<div class="alert alert-danger text-align-center">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</div>
					@endif
					
					{{-- Yield main content --}}
          @yield('content')
        </main>
    </div>
</body>
</html>
