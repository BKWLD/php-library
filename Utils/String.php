<?php namespace BKWLD\Utils;

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
	
}