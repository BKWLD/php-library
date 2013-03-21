<?php namespace BKWLD\APIs\Facebook;

// Dependencies
use \Laravel\Cache;
use \Exception;
use \Laravel\Log;


/**
 * Load a feed, like a wall and cache it
 */
class Feed {
	
	// Settings
	const CACHE_ID = 'facebook-feed';
	public static $cache_minutes = 10;

	/**
	 * Load a feed from an open graph resource
	 * @param $id - A facebook graph id or string
	 * @param $options - An array that gets merged with the defaults
	 */
	public static function get($id, $options = null) {
		
		// Return cached response if exists
		$cache_id = self::CACHE_ID.$id;
		if ($cached = Cache::get($cache_id)) return $cached;
		
		// Default options
		$defaults = array(
			'limit' => 20,
			'until' => null,
		);
		
		// Apply user options
		if (is_array($options)) $options = array_merge($defaults, $options);
		$params = http_build_query($options);
		
		// Query
		$facebook = Connect::sdk();
		$response = $facebook->api($id.'/feed?'.$params);
		$response = $response['data']; // Trim out the meta shit
		
		// Cache the response
		Cache::put($cache_id, $response, self::$cache_minutes);
		
		// Return the response
		return $response;
		
	}
	
}