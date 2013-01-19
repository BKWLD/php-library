<?php namespace BKWLD\Laravel;

// Dependencies
use Laravel\Request;

class Input {
	
	/**
	 * Get an array of all input from either JSON or POST
	 */
	public static function json_or_input() {
		$json = \Laravel\Input::json(); // Had to save to var to test for empty
		return Request::ajax() && !empty($json) ? (array) $json : \Laravel\Input::all();
	}
	
}