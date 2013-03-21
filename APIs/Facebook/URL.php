<?php namespace BKWLD\APIs\Facebook;

/**
 * Utilities for dealing with user
 */
class URL {

	/**
	 * Deep link to user's page
	 */	
	static public function user($handle) {
		return 'https://facebook.com/'.$handle;
	}
	
}