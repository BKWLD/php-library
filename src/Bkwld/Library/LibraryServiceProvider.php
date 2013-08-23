<?php namespace Bkwld\Library;

// Dependencies
use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bkwld/library');
				
		// Register Laravel helpers on the running app
		Laravel\Macros::register($this->app);
		
		// Register validators
		$validator = $this->app->make('validator');
		$validator->extend('unique_with', 'Bkwld\Library\Laravel\Validator@uniqueWith');
		$validator->extend('file', 'Bkwld\Library\Laravel\Validator@file');

		// Make the constants class easier to use
		// class_alias('\BKWLD\Library\Utils\Constants', 'Constants');
	
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}