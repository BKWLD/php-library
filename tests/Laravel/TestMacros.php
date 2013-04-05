<?php

// Dependencies
use Bkwld\Library\Laravel\Macros;
use Mockery as m;

class MacrosTest extends PHPUnit_Framework_TestCase {
	
	public function testRegisterCallabilty() {
		
		// Mock the app.
		$app = m::mock('app')->shouldReceive('make')->with('html')->times(1)->andReturnUsing(function() {
			return m::mock('html')->shouldReceive('macro')->with(m::any(), m::type('callable'))->getMock();
		})->getMock();
		
		// The mock conditions are the test
		Macros::register($app);
		
	}
	
}