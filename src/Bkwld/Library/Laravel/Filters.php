<?php namespace Bkwld\Library\Laravel;

// Imports
use Response;
use Request;
use Input;
use Session;
use Log;

class Filters {
	
	/**
	 * Check for CSRF token on all submits.  This is designed to be called from
	 * the before filter like:
	 * 
	 * Route::filter('before', function() {
	 *	if (!URI::is('/exempt/route') && 
	 *		$result = BKWLD\Laravel\Filters::csrf()) {
	 *		return $result;
	 *	}
	 * });
	 *
	 */
	static public function csrf() {
		
		// The response to this call is an array, so break out the value
		$header_csrf = Request::header('x-csrf');
		if (!empty($header_csrf)) $header_csrf = $header_csrf[0];
		
		// Wrap all requests in the CSRF filter.  This
		// makes sure all non-GET requests have a valid CSRF.
		if (Request::getMethod() != 'GET'
			&& Input::get('_token') != Session::token() // Checks form submit
			&& $header_csrf != Session::token() // Checks AJAX
			) {
			
			// Show error screen
			throw new \Illuminate\Session\TokenMismatchException;
		}
	}

}