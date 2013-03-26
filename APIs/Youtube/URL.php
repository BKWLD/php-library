<?php namespace BKWLD\APIs\Youtube;

/**
 * Utilities for generating and parsing urls
 */
class URL {

	/**
	 * Parse Youtube URLs to get their IDs.  Accepts URLs like:
	 */	
	static public function id($url) {
		
		// Get ones like http://www.youtube.com/watch?v=QH2-TGUlwu4
		if (preg_match('#v=([\w-]*)#i', $url, $matches)) return $matches[1];
		
		// Get ones like http://youtu.be/QH2-TGUlwu4
		if (preg_match('#youtu.be/([\w-]*)$#i', $url, $matches)) return $matches[1];
		
		// No matches were found
		return false;
		
	}
	
	/**
	 * Get a thumbnail image
	 * @param $id A youtube video id
	 * @param $type A YouTube thumbnail type.  Accepts:
	 * 		- default - 120x90-ish
	 *		- mqdefault - 320x180-ish
	 * 		- hqdefault - 480x360-ish
	 * 		- maxresdefault - 1280x720-ish
	 */
	static public function thumbnail($id, $type = 'default') {
		
		// Allowed types
		if (!in_array($type, array('default', 'mqdefault', 'hqdefault', 'maxresdefault'))) throw new Exception('Type not supported: '. $type);
		
		// Make the url
		return '//img.youtube.com/vi/'.$id.'/'.$type.'.jpg';
		
	}
	
}