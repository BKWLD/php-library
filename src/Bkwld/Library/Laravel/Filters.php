<?php namespace Bkwld\Library\Laravel;

// Imports
use Response;
use Request;
use Input;
use Session;

class Filters {
	
	/**
	 * Check for CSRF token on all submits.  This is designed to be called from
	 * the before filter like:
	 * 
	 * Route::filter('before', function() {
	 *	BKWLD\Laravel\Filters::csrf()) {
	 * });
	 *
	 */
	static public function csrf() {
		
		// Wrap all requests in the CSRF filter.  This
		// makes sure all non-GET requests have a valid CSRF.
		if (Request::getMethod() != 'GET'
			&& Input::get('_token') != Session::token() // Checks form submit
			&& Request::header('x-csrf') != Session::token() // Checks AJAX
			) {
			
			// Show error screen
			throw new \Illuminate\Session\TokenMismatchException;
		}
	}

}