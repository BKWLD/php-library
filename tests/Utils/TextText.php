<?php namespace Tests\Utils;

use Bkwld\Library\Utils\Text;
use InvalidArgumentException;

class TextTest extends \PHPUnit_Framework_TestCase {

	public function testBytesFromHuman() {

		// Non-fractional
		$this->assertEquals(1, Text::bytesFromHuman('1b'));
		$this->assertEquals(2, Text::bytesFromHuman('2 bytes'));
		$this->assertEquals(1024, Text::bytesFromHuman('1k'));
		$this->assertEquals(1024, Text::bytesFromHuman('1 kb'));
		$this->assertEquals(1126, Text::bytesFromHuman('1.1kb')); // Tests rounding
		$this->assertEquals(10240, Text::bytesFromHuman('10KB'));
		$this->assertEquals(pow(1024, 2), Text::bytesFromHuman('1m'));
		$this->assertEquals(pow(1024, 3), Text::bytesFromHuman('1g'));

		// Fractional
		$this->assertEquals(1536, Text::bytesFromHuman('1.5k'));

		// Invalid
		$this->expectException(InvalidArgumentException::class);
		Text::bytesFromHuman('No number');
	}

}
