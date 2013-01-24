<?php namespace BKWLD\Utils;

// Utilities for dealing with strings
class String {

	/**
	 * Convert a key / slug into a friendly title string
	 * @param string $keyword i.e. "some_multi_key"
	 * @return string i.e. "Some multi key"
	 */
	static public function title_from_key($keyword) {
		return ucfirst(str_replace('_', ' ', $keyword));
	}
	
}