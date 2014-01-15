<?php

use Bkwld\Library\Utils\URL;

class TestUtilsURL extends PHPUnit_Framework_TestCase {

	public function testUnsetParam() {
		$this->assertEquals('http://domain.com/whatever', URL::unsetParam('http://domain.com/whatever?foo=bar', 'foo'));
		$this->assertEquals('http://domain.com/whatever?dude=bro', URL::unsetParam('http://domain.com/whatever?foo=bar&dude=bro', 'foo'));
		$this->assertEquals('http://domain.com/whatever?dude=bro', URL::unsetParam('http://domain.com/whatever?dude=bro&foo=bar', 'foo'));
		$this->assertEquals('http://domain.com/whatever', URL::unsetParam('http://domain.com/whatever', 'foo'));
		$this->assertEquals('http://domain.com/whatever?foo=bar', URL::unsetParam('http://domain.com/whatever?foo=bar', 'bar'));
	}

	public function testBuildUrl() {

		$this->assertEquals('http://domain.com/whatever', URL::buildUrl(array(
			'scheme' => 'http',
			'host' => 'domain.com',
			'path' => '/whatever',
		)));

		$this->assertEquals('http://domain.com/whatever?dude=bro&foo=bar', URL::buildUrl(array(
			'scheme' => 'http',
			'host' => 'domain.com',
			'path' => '/whatever',
			'query' => 'dude=bro&foo=bar',
		)));

	}

}