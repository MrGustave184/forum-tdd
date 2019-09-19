<?php

namespace App\Providers;
use App\Channel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
				Schema::defaultStringLength(191);
				
				// // Inject a variable into a view (channels in this case)
				// \View::composer('threads.create', function($view) {
				// 	$view->with('channels', \App\Channel::all());
				// });

				// // Share a variable across all views
				// \View::composer('*', function($view) {
				// 	$view->with('channels', \App\Channel::all());
				// });

				// Share a variable across all views
				// This is caching the channels automatically????????
				// \View::share('channels', Channel::all());

				// To improve performance, we gonna cache the channels (because they dont change very often)
				// Before injecting them in every view
				\View::composer('*', function ($view) {
						$channels = \Cache::rememberForever('channels', function () {
								return Channel::all();
						});

						$view->with('channels', $channels);
				});
				
    }
}
