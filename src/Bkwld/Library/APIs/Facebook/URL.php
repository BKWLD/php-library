<?php namespace BKWLD\Library\APIs\Facebook;

/**
 * Utilities for generating and parsing urls
 */
class URL {

	/**
	 * Deep link to user's page
	 */	
	static public function user($handle) {
		return 'https://facebook.com/'.$handle;
	}
	
}