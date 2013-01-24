<?php namespace BKWLD\APIs\Twitter;

// Dependencies
use \Laravel\Config;
use \Laravel\Log;
use \Laravel\Session;
use \Laravel\Input;
use \Exception;
require_once 'twitteroauth/twitteroauth/twitteroauth.php';
use \TwitterOAuth;

class OAuth {
	
	/**
	 * Build the authorization url.  This logic is taken from TwitterOAuth's redirect.php
	 */
	public static function url() {
		
		// Build TwitterOAuth object with client credentials.
		$connection = new TwitterOAuth(Config::get('twitter.consumer_key'), Config::get('twitter.consumer_secret'));
		
		// Get temporary credentials.
		$request_token = $connection->getRequestToken(Config::get('twitter.redirect_uri'));
		
		// Save tokens to the session for retrieval by exchange_token.
		Session::put('twitter.oauth_token', $request_token['oauth_token']);
		Session::put('twitter.oauth_token_secret', $request_token['oauth_token_secret']);
		
		// Build authorize URL 
		return $connection->getAuthorizeURL($request_token['oauth_token']);
		
	}

	/**
	 * Handle the callback request from Twitter.  This logic is taken from TwitterOAuth's callback.php
	 * @returns array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham")
   * ... but as an object
	 */
	public static function exchange_token() {
		
		// Create TwitteroAuth object with app key/secret and token key/secret from default phase
		$connection = new TwitterOAuth(Config::get('twitter.consumer_key'), 
			Config::get('twitter.consumer_secret'), 
			Session::get('twitter.oauth_token'), 
			Session::get('twitter.oauth_token_secret')
		);
		
		// Request access tokens from twitter
		$response = $connection->getAccessToken(Input::get('oauth_verifier'));
		if (empty($response['oauth_token'])) throw new Exception('Missing access token in the response');
		
		// Unset session vars and return
		Session::forget('twitter.oauth_token');
		Session::forget('twitter.oauth_token_secret');
		return (object) $response;
	}
	
}