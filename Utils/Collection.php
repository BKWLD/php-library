<?php
namespace BKWLD\Utils;

// Utilities for dealing with arrays and other collections
class Collection {

	/**
	 * Return a random value from an array
	 * @param array $ar
	 * @return mixed The random value
	 */
	static public function random_value($ar) {
		return $ar[array_rand($ar)];
	}
	
}