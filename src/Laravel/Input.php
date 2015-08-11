<?php namespace Bkwld\Library\Laravel;

// Dependencies
use Request;

class Input {
	
	/**
	 * Remove a value from Laravel's Input
	 */
	public static function remove($key) {
		$input = \Laravel\Input::get();
		unset($input[$key]);
		\Laravel\Input::replace($input);
		return $input;
	}
	
}