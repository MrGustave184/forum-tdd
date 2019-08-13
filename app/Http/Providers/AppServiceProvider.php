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
				\View::share('channels', Channel::all());
    }
}
