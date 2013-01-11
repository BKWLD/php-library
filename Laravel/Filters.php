<?php namespace BKWLD\Laravel;

// Imports
use \Laravel\Response;
use \Laravel\Request;
use \Laravel\Input;
use \Laravel\Session;

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
		if (Request::method() != 'GET'
			&& Request::forged() // Checks form submits
			&& $header_csrf != Session::token() // Checks AJAX
			) {
			
			// Show error screen
			Log::info('CSRF denied');
			return Response::error('500');
		}

		// Remove the CSRF token from the Input so it doesn't screw up
		// mass assignment.  It was trying to save it to models before this.
		// Also, this keeps the file data in place
		$input = Input::get();
		unset($input['csrf_token']);
		Input::replace($input);
		
		// Continue normal execution
		return false;
	}

}