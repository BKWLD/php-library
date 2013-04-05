<?php

/**
 * Test if things are found by the autoloader
 */
class AutoloadTest extends PHPUnit_Framework_TestCase {
	
	public function testUtils() {
		$this->assertTrue(class_exists('\Bkwld\Library\Utils\String'));
		$this->assertTrue(class_exists('\Bkwld\Library\Utils\File'));
	}
	
	public function testLaravel() {
		$this->assertTrue(class_exists('\Bkwld\Library\Laravel\Filters'));
	}
	
	public function testAPIs() {
		$this->assertTrue(class_exists('\Bkwld\Library\APIs\Facebook\Feed'));
		$this->assertTrue(class_exists('\Bkwld\Library\APIs\Instagram\Feed'));
		$this->assertTrue(class_exists('\Bkwld\Library\APIs\Twitter\Feed'));
	}
	
}