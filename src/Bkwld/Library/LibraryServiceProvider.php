<?php namespace Bkwld\Library;

// Dependencies
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
		
		// If doing local development, auto generate oauth redirect uris
		// if ($this->app->environment() == 'local') {
		// 	foreach(array('instagram', 'twitter') as $service) {
		// 		$this->app['router']->get('/oauth/');
		// 		Route::get($this->dir.'/commands', array('uses' => 'Bkwld\Decoy\Controllers\Commands@index', 'as' => 'decoy\commands'));
		// 	}
		// }
		
		// Register commands
		$this->app->singleton('command.library.instagram.oauth_url', function($app) {
			return new APIs\Instagram\Commands\OAuthURL;
		});
		$this->app->singleton('command.library.instagram.access_token', function($app) {
			return new APIs\Instagram\Commands\AccessToken;
		});
		$this->commands(array('command.library.instagram.oauth_url', 'command.library.instagram.access_token'));

		// Make the constants class easier to use
		// class_alias('\BKWLD\Library\Utils\Constants', 'Constants');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array('command.library.instagram.oauth_url', 'command.library.instagram.access_token');
	}

}