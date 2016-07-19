<?php namespace Bkwld\Library\Utils;

// Utilities for dealing with arrays and other collections
class Collection {

	/**
	 * Return a random value from an array
	 * @param array $ar
	 * @return mixed The random value
	 */
	static public function randomValue($ar) {
		return $ar[array_rand($ar)];
	}
	
	/**
	 * Replace all the empty strings in an array with NULL.  An empty string
	 * excludes numeric 0.
	 */
	static public function nullEmpties($ar) {
		foreach($ar as &$val) {
			if (!isset($val) || $val === '' || $val === false || $val == array()) $val = null;
		}
		return $ar;
	}
	
	/**
	 * Check if the key is either in an array (it is the value of 
	 * a numeric key) or if it itself a key
	 */
	static public function keyOrValueExists($key, $ar) {
		return array_key_exists($key, $ar) || in_array($key, $ar);
	}
	
}