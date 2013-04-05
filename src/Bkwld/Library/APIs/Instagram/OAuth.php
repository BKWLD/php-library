<?php namespace Bkwld\Library\APIs\Instagram;

// Dependencies
use \Laravel\Config;
use \Laravel\Log;
use \Exception;

class OAuth {
	
	/**
	 * Build the authorization url
	 */
	public static function url() {
		$client_id = Config::get('instagram.client_id');
		$redirect_uri = Config::get('instagram.redirect_uri');
		return "https://api.instagram.com/oauth/authorize/?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=code";
		
	}
	
	/**
	 * Exchange a code for an access token and basic user info.  The response looks like:
	 * {
   * 		"access_token": "fb2e77d.47a0479900504cb3ab4a1f626d174d2d",
   * 		"user": {
   * 			"id": "1574083",
   * 			"username": "snoopdogg",
   * 			"full_name": "Snoop Dogg",
   * 			"profile_picture": "http://distillery.s3.amazonaws.com/profiles/profile_1574083_75sq_1295469061.jpg"
   * 		}
   * }
	 */
	public static function exchange_code($code) {
		
		// Create the URL
		$url = 'https://api.instagram.com/oauth/access_token';
		
		// The POST data
		$data = array(
			'client_id' => Config::get('instagram.client_id'),
			'client_secret' => Config::get('instagram.client_secret'),
			'redirect_uri' => Config::get('instagram.redirect_uri'),
			'grant_type' => 'authorization_code',
			'code' => $code,
		);
		
		// Talk to instagram
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		if (!($response = curl_exec($ch))) throw new Exception('Access token could not be fetched');
		curl_close($ch);
		
		// Validate response and return
		$response = json_decode($response);
		if (!empty($response->error_message)) throw new Exception($response->error_message);
		if (empty($response->access_token)) throw new Exception('Missing access token in response');
		return $response;
		
	}
	
}