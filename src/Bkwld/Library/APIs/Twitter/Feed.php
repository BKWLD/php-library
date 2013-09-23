<?php namespace Bkwld\Library\APIs\Twitter;

// Dependencies
use Cache;
use Exception;
use Log;

/**
 * Run get lists of tweets and cache them
 */
class Feed {

	// Settings
	const CACHE_ID = 'twitter-feed';
	public static $cache_minutes = 10;

	/**
	 * Get the most recent tweets by a user and cache the results
	 * for a period of time
	 * @param $username - Username without the "@"
	 */
	public static function user($username, $options = null) {
		
		// Return cached response if exists
		$cache_id = self::CACHE_ID.$username;
		if (self::$cache_minutes && $cached = Cache::get($cache_id)) return $cached;
		
		// Default options
		$defaults = array(
			'screen_name' => $username,
			'count' => 20,
			'trim_user' => 1,
			'exclude_replies' => 1,
			'contributor_details' => 1,
			'include_rts' => 0,
		);
		
		// Apply user options
		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;
		$params = http_build_query($options);
		
		// Get the tweets
		$connection = Connect::OAuth();
		$request = 'statuses/user_timeline?'.$params;
		$response = $connection->get('statuses/user_timeline.json?'.$params);
		
		// Test response for errors
		if (!empty($response->errors)) throw new Exception('Twitter error: '.$response->errors[0]->message);
		if (!empty($response->error)) throw new Exception('Twitter error: '.$response->error);
		if (!is_array($response)) throw new Exception('Twitter response not an error: '.print_r($response, true));
		
		// Cache the response
		if (self::$cache_minutes) Cache::put($cache_id, $response, self::$cache_minutes);
		
		// Return the response
		return $response;
		
	}
}

