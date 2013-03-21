<?php namespace BKWLD\APIs\Instagram;

// Dependencies
use \Laravel\Cache;
use \Exception;
use \Laravel\Log;
use \Laravel\Config;

/**
 * Load a feed and caches it
 */
class Feed {
	
	// Settings
	const CACHE_ID = 'instagram-feed';
	public static $cache_minutes = 10;

	/**
	 * Load a feed from an open graph resource
	 * @param $id - An instagram user id
	 * @param $options - An array that gets merged with the defaults
	 */
	public static function user($id, $options = null) {
		
		// Return cached response if exists
		$cache_id = self::CACHE_ID.$id;
		if ($cached = Cache::get($cache_id)) return $cached;
		
		// Default options
		$defaults = array(
			'count' => 20,
			'access_token' => Config::get('instagram.access_token'),
		);
		
		// Apply options
		if (is_array($options)) $options = array_merge($defaults, $options);
		$params = http_build_query($options);
		
		// Query
		$url = 'https://api.instagram.com/v1/users/'.$id.'/media/recent?'.$params;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (!($response = curl_exec($ch))) throw new Exception('Feed could not be executed');
		curl_close($ch);
		
		// Verify the response
		$response = json_decode($response);
		if ($response->meta->code != 200) throw new Exception('Instagram error:'.$response->meta->error_message);
		$response = $response->data;
		
		// Cache the response
		Cache::put($cache_id, $response, self::$cache_minutes);
		
		// Return the response
		return $response;
		
	}
	
}