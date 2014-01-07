<?php namespace Bkwld\Library\Laravel;

// Imports
use App;
use Config;
use Response;
use Redirect;
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
		$method = Request::getMethod();
		$token = Session::token();
		if ($method != 'GET'
			&& $method != 'HEAD'
			&& Input::get('_token') != $token // Checks form submit
			&& Request::header('x-csrf') != $token // Checks AJAX
			) {
			
			// Show error screen
			throw new \Illuminate\Session\TokenMismatchException;
		}
	}

	/**
	 * Require authentication when not live and not local.  For instance,
	 * when the site is on Pagoda while in development.
	 * @return  Illuminate\Http\Response | FALSE
	 */
	static public function requireDecoyAuthUntilLive() {

		// Require Decoy
		if (!App::bound('decoy')) return false;
		
		// Determine whether redirect should be made
		if (Config::get('site.live') 
			|| App::isLocal() 
			|| app('decoy.auth')->check() 
			|| app('decoy.filters')->isPublic() 
			|| Request::is('robots.txt', 'favicon.ico')
			) return false;

		// Redirect to the decoy login page
		return Redirect::action(app('decoy.auth')->loginAction())->with(array(
			'login_notice' => 'Until this site is pushed live, you must authenticate to view the previous URL',
			'login_redirect' => Request::fullUrl(),
		));
	}

}