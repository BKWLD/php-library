<?php namespace Bkwld\Library;

// Dependencies
use Input;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {

		// Register validators
		$validator = $this->app->make('validator');
		$validator->extend('unique_with', 'Bkwld\Library\Laravel\Validator@uniqueWith');
		$validator->extend('file', 'Bkwld\Library\Laravel\Validator@file');
		$validator->extend('video', 'Bkwld\Library\Laravel\Validator@video');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() { }

}
