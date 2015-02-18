<?php namespace Bkwld\Library\Laravel;

// Imports
use App;
use Config;
use Response;
use Redirect;
use Request;
use Input;
use Session;
use Str;

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
		if ((Config::get('site.live') && App::environment() == 'production')
			|| App::isLocal() 
			|| app('decoy.auth')->check() // They are already logged in
			|| app('decoy')->handling() // If Decoy is handling, trust to its auth
			|| Request::is('robots.txt', 'favicon.ico')
			) return false;

		// Redirect to the decoy login page
		return Redirect::action(app('decoy.auth')->loginAction())->with(array(
			'login_notice' => 'Until this site is pushed live, you must authenticate to view the previous URL',
			'login_redirect' => Request::fullUrl(),
		));
	}

	/**
	 * Return a robots.txt with rules that change depending on whether the site
	 * is live or not
	 */
	static public function conditionalRobots($blacklist = array()) {

		// Add some defaults to the blacklist
		array_push($blacklist, 'pagoda', '.dev');

		// Assemble robots content
		$body = "User-agent: *\nDisallow: ";
		if (Str::contains(Request::getHost(), $blacklist) || !Config::get('site.live')) $body .= "/";

		// Respond as text
		$response = Response::make($body, '200');
		$response->header('Content-Type', 'text/plain');
		return $response;

	}

}
