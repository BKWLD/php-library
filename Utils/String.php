<?php namespace BKWLD\Utils;

// Dependencies
require_once('vendor/kwi-urllinker/UrlLinker.class.php');
use \Kwi\UrlLinker;

// Utilities for dealing with strings
class String {

	/**
	 * Convert a key / slug into a friendly title string
	 * @param string $keyword i.e. "some_multi_key"
	 * @return string i.e. "Some multi key"
	 */
	static public function title_from_key($keyword) {
		
		// Check for the keyword in Laravel's translation system
		if (function_exists('__')) {
			if (\Laravel\Lang::has('admin.'.$keyword)) return __('admin.'.$keyword);
			if (\Laravel\Lang::has('application.'.$keyword)) return __('application.'.$keyword);
		}
		
		// Otherwise, auto format it
		return ucfirst(str_replace('_', ' ', $keyword));
	}
	
	/**
	 * Add HTML links to URLs in a string.  This loads a vendor PHP
	 * file into this function because it registers global functions
	 * that I don't want in the global space
	 */
	static public function linkify($text, $options = array()) {
		
		// Default options
		$defaults = array(
			'target' => '_blank',
		);
		
		// Apply user options
		if (is_array($options)) $options = array_merge($defaults, $options);
		
		// Generate the link
		$url_linker = new UrlLinker;
		return $url_linker->parse($text, $options);
	}
	
}