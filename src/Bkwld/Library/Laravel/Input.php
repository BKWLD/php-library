<?php namespace BKWLD\Library\Laravel;

// Dependencies
use Laravel\Request;

class Input {
	
	/**
	 * Get an array of all input from either JSON or POST
	 */
	public static function json_or_input() {
		$json = \Laravel\Input::json(); // Had to save to var to test for empty
		return Request::ajax() && !empty($json) ? (array) $json : \Laravel\Input::get();
	}
	
	/**
	 * Merge the JSON input into the regular input
	 */
	public static function json_and_input() {
		$json = \Laravel\Input::json();
		if (Request::ajax() && !empty($json)) return array_merge(\Laravel\Input::get(), (array) $json);
		else return \Laravel\Input::get();
	}
	
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