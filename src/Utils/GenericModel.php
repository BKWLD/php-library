<?php namespace Bkwld\Library\Utils;

/**
 * Has magic methods for adding properties to a class magically, like a Laravel model
 */
abstract class GenericModel {

	/**
	 * This is where the magic attribtues are stored
	 * @var array
	 */
	private $attributes = array();

	/**
	 * Set initial attributes on load
	 */
	public function __construct(array $attributes = array()) {
		$this->attributes = $attributes;
	}

	/**
	 * Convert the model instance to JSON.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0) {
		return json_encode($this->toArray(), $options);
	}

	/**
	 * Convert the model instance to an array.
	 *
	 * @return array
	 */
	public function toArray() {
		return $this->attributes;
	}


	/**
	 * Dynamically retrieve attributes on the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key) {
		if (array_key_exists($key, $this->attributes)) {
			return $this->attributes[$key];
		}
	}

	/**
	 * Dynamically set attributes on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value) {
		$this->attributes[$key] = $value;
	}

	/**
	 * Determine if an attribute exists on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __isset($key) {
		return isset($this->attributes[$key]);
	}

	/**
	 * Unset an attribute on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __unset($key) {
		unset($this->attributes[$key]);
	}

	/**
	 * Convert the model to its string representation.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->toJson();
	}

}
