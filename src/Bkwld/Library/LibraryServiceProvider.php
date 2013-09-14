<?php namespace Bkwld\Library;

// Dependencies
use Input;
use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
		$this->package('bkwld/library');
		
		// Register Laravel helpers on the running app
		Laravel\Macros::register($this->app);
		
		// // Register validators
		$validator = $this->app->make('validator');
		$validator->extend('unique_with', 'Bkwld\Library\Laravel\Validator@uniqueWith');
		$validator->extend('file', 'Bkwld\Library\Laravel\Validator@file');
		
		// Instagram access token helper
		$view = $this->app->make('view');
		$this->app['router']->get('/oauth/instagram/access_token', function() use ($view) {
			return $view->make('library::instagram.access_token', array(
				'url' => APIs\Instagram\OAuth::url(),
				'response' => Input::has('code') ? APIs\Instagram\OAuth::exchangeCode(Input::get('code')) : null,
			));
		});

		// Make the constants class easier to use
		// class_alias('\BKWLD\Library\Utils\Constants', 'Constants');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array();
	}

}