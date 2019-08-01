<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	$repos = [
    		'User',
    		'Player',
    		'Campaign',
    		'Char',
    		'Item'
    	];

    	foreach ($repos as $repo) {
        	$this->app->bind("App\Repositories\\{$repo}\\{$repo}Repository",
        		"App\Repositories\\{$repo}\\{$repo}RepositoryImpl");
       	}
    }
}
