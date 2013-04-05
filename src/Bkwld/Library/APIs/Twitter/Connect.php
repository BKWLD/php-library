<?php namespace BKWLD\Library\APIs\Twitter;

// Dependencies
require_once 'twitteroauth/twitteroauth/twitteroauth.php';
use \TwitterOAuth;
use \Laravel\Config;

/**
 * Connect to Twitter using Laravel credentials
 */
class Connect {
	public static $connection;
	public static function OAuth() {
		if (self::$connection) return self::$connection;
		self::$connection = new TwitterOAuth(
			Config::get('twitter.consumer_key'), 
			Config::get('twitter.consumer_secret'),
			Config::get('twitter.access_token'),
			Config::get('twitter.access_token_secret')
		);
		return self::$connection;
	}
}