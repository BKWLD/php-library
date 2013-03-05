<?php namespace BKWLD\APIs\Facebook;

// Dependencies
require_once 'sdk/src/facebook.php';
use \Laravel\Config;

/**
 * Connect to Twitter using Laravel credentials
 */
class Connect {
	public static $connection;
	public static function sdk() {
		if (self::$connection) return self::$connection;
		self::$connection = new \Facebook(array(
			'appId'  => Config::get('facebook.app_id'),
			'secret' => Config::get('facebook.app_secret'),
		));
		return self::$connection;
	}
}