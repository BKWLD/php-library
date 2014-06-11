<?php namespace Bkwld\Library\APIs\Instagram;

// Dependencies
use Cache;
use Exception;
use Log;
use Config;

/**
 * Load a feed and caches it
 */
class Feed {
	
	// Settings
	const CACHE_ID = 'instagram-feed';
	public static $cache_minutes = 10;

	/**
	 * Load a feed from a specic user by their id
	 * @param $id - An instagram user id
	 * @param $options - An array that gets merged with the defaults
	 */
	public static function user($id, $options = null) {
		
		// Return cached response if exists
		$cache_id = self::CACHE_ID.$id;
		if (self::$cache_minutes && $cached = Cache::get($cache_id)) return $cached;
		
		// Default options
		$defaults = array(
			'count' => 20,
			'access_token' => Config::get('instagram.access_token'),
		);
		
		// Apply options
		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;
		$params = http_build_query($options);
		
		// Query
		$url = 'https://api.instagram.com/v1/users/'.$id.'/media/recent?'.$params;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (!($response = curl_exec($ch))) throw new Exception('Feed could not be executed');
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		// Verify the response
		if ($http_code != 200) throw new Exception('Bad HTTP code:'.$http_code);
		$response = json_decode($response);
		if (empty($response->meta->code)) throw new Exception('No meta code: '.print_r($response,true));
		if ($response->meta->code != 200) throw new Exception('Instagram error:'.$response->meta->error_message);
		$response = $response->data;
		
		// Cache the response
		if (self::$cache_minutes) Cache::put($cache_id, $response, self::$cache_minutes);
		
		// Return the response
		return $response;
		
	}
	
}