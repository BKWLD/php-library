<?php namespace BKWLD\APIs\Instagram;

/**
 * Utilities for dealing with user
 */
class URL {

	/**
	 * Deep link to user's page
	 */	
	static public function user($handle) {
		return 'http://instagram.com/'.$handle;
	}
	
}