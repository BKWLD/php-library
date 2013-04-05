<?php namespace BKWLD\Library\APIs\Instagram;

/**
 * Utilities for generating and parsing urls
 */
class URL {

	/**
	 * Deep link to user's page
	 */	
	static public function user($handle) {
		return 'http://instagram.com/'.$handle;
	}
	
}